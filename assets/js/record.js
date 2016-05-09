  var audio_context;
  var recorder;

    var audioInput = null,
        realAudioInput = null,
        inputPoint = null;
        // audioRecorder = null;
    var rafID = null;
    var analyserContext = null;
    var canvasWidth, canvasHeight;
    var recIndex = 0;

  function startUserMedia(stream) {
    var input = audio_context.createMediaStreamSource(stream);
  //   __log('Media stream created.' );
  // __log("input sample rate " +input.context.sampleRate);

    // Feedback!
    //input.connect(audio_context.destination);
    // __log('Input connected to audio context destination.');

    recorder = new Recorder(input, {
                  numChannels: 1
                });
    // __log('Recorder initialised.');
  }

  function gotStream(stream) {
    var input = audio_context.createMediaStreamSource(stream);
  //   __log('Media stream created.' );
  // __log("input sample rate " +input.context.sampleRate);

     analyserNode = audio_context.createAnalyser();
    analyserNode.fftSize = 2048;
    input.connect( analyserNode );

    // Feedback!
    //input.connect(audio_context.destination);
    // __log('Input connected to audio context destination.');

    recorder = new Recorder(input, {
                  numChannels: 1
                });
    // __log('Recorder initialised.');

   
 

    zeroGain = audio_context.createGain();
    zeroGain.gain.value = 0.0;
    input.connect( zeroGain );
    zeroGain.connect( audio_context.destination );
    updateAnalysers();
}

  function startRecording(button) {
    recorder && recorder.record();
    button.disabled = true;
    button.nextElementSibling.disabled = false;
    // __log('Recording...');
  }

  function stopRecording(button) {
    recorder && recorder.stop();
    button.disabled = true;
    button.previousElementSibling.disabled = false;
    // __log('Stopped recording.');

    // create WAV download link using audio data blob
    createDownloadLink();

    recorder.clear();
  }

  function startRecording(button) {
    recorder && recorder.record();
    button.disabled = true;
    button.nextElementSibling.disabled = false;
    // __log('Recording...');
  }

  function stopRecording(button) {
    recorder && recorder.stop();
    button.disabled = true;
    button.previousElementSibling.disabled = false;
    // __log('Stopped recording.');

    // create WAV download link using audio data blob
    createDownloadLink();

    recorder.clear();
  }

  function createDownloadLink() {
    recorder && recorder.exportWAV(function(blob) {

    });
  }

  window.onload = function init() {
    try {
      // webkit shim
      window.AudioContext = window.AudioContext || window.webkitAudioContext;
      navigator.getUserMedia = ( navigator.getUserMedia ||
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);
      window.URL = window.URL || window.webkitURL;

      audio_context = new AudioContext;
      // __log('Audio context set up.');
      // __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
    } catch (e) {
      alert('No web audio support in this browser!');
    }

    navigator.getUserMedia({audio: true}, gotStream, function(e) {
      // __log('No live audio input: ' + e);
    });
  };


// window.AudioContext = window.AudioContext || window.webkitAudioContext;



/* TODO:

- offer mono option
- "Monitor input" switch
*/

function saveAudio() {
    recorder.exportWAV( doneEncoding );
    // could get mono instead by saying
    // audioRecorder.exportMonoWAV( doneEncoding );
}

function gotBuffers( buffers ) {
    var canvas = document.getElementById( "wavedisplay" );

    drawBuffer( canvas.width, canvas.height, canvas.getContext('2d'), buffers[0] );

    // the ONLY time gotBuffers is called is right after a new recording is completed - 
    // so here's where we should set up the download.
    recorder.exportWAV( doneEncoding );
}

function doneEncoding( blob ) {
    Recorder.setupDownload( blob, "myRecording" + ((recIndex<10)?"0":"") + recIndex + ".mp3" );
    recIndex++;
}

function toggleRecording( e ) {
    if (e.classList.contains("recording")) {
        // stop recording
        recorder && recorder.stop();
        e.classList.remove("recording");
        // audioRecorder.getBuffers( gotBuffers );
        createDownloadLink();

        recorder.clear();
        
        $(".btn-record").css("background", "#0F72A5");
        

    } else {
        // start recording
        // if (!audioRecorder)
        //     return;
        e.classList.add("recording");
        // audioRecorder.clear();
        recorder && recorder.record();
        $(".audio_section").css("visibility","visible");
        $('.playback_wrapper').removeClass("visible");
        $("#viz").show();
        $(".btn-record").html("<i class='fa fa-stop'></i>");
        $(".btn-record").css("background", "#D24844");
        

    }
}

function convertToMono( input ) {
    var splitter = audio_context.createChannelSplitter(2);
    var merger = audio_context.createChannelMerger(2);

    input.connect( splitter );
    splitter.connect( merger, 0, 0 );
    splitter.connect( merger, 0, 1 );
    return merger;
}

function cancelAnalyserUpdates() {
    window.cancelAnimationFrame( rafID );
    rafID = null;
}

function updateAnalysers(time) {
    if (!analyserContext) {
        var canvas = document.getElementById("analyser");
        canvasWidth = canvas.width;
        canvasHeight = canvas.height;
        analyserContext = canvas.getContext('2d');
    }

    // analyzer draw code here
    {
        var SPACING = 6;
        var BAR_WIDTH = 3;
        var numBars = Math.round(canvasWidth / SPACING);
        var freqByteData = new Uint8Array(analyserNode.frequencyBinCount);

        analyserNode.getByteFrequencyData(freqByteData); 

        analyserContext.clearRect(0, 0, canvasWidth, canvasHeight);
        analyserContext.fillStyle = '#F6D565';
        analyserContext.lineCap = 'round';
        var multiplier = analyserNode.frequencyBinCount / numBars * 1.2;

        // Draw rectangle for each frequency bin.
        for (var i = 0; i < numBars; ++i) {
            var magnitude = 0;
            var offset = Math.floor( i * multiplier );
            // gotta sum/average the block, or we miss narrow-bandwidth spikes
            for (var j = 0; j< multiplier; j++)
                magnitude += freqByteData[offset + j];
            magnitude = magnitude / multiplier;
            var magnitude2 = freqByteData[i * multiplier];
            analyserContext.fillStyle = "#dddddd";
            analyserContext.fillRect(i * SPACING, canvasHeight, BAR_WIDTH, -magnitude);
        }
    }
    
    rafID = window.requestAnimationFrame( updateAnalysers );
}

function toggleMono() {
    if (audioInput != realAudioInput) {
        audioInput.disconnect();
        realAudioInput.disconnect();
        audioInput = realAudioInput;
    } else {
        realAudioInput.disconnect();
        audioInput = convertToMono( realAudioInput );
    }

    audioInput.connect(inputPoint);
}

$('.remove_recording').click(function(){
    $(".playback_wrapper").removeClass("visible");
    $(".playback_wrapper").css("visibility","hidden");
    $('.remove_recording').removeClass("visible");
    $('.remove_recording').css("visibility","hidden");
    $("input[name='recording']").val("");
    $(".play_both").removeClass("visible");
});