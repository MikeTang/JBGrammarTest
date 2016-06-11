pushd /www/gitWeb/grammar
git pull

pushd /www/https/yufa/
cp -R /www/gitWeb/grammar/* .
cp intactFiles/index.php .

