#!/usr/bin/env python
# -*- coding: utf-8 -*-

import requests
from bs4 import BeautifulSoup
import csv
import time
import os.path
import sys
import codecs

from random import shuffle

def read(filename):
    try:
        f = codecs.open(filename, encoding='utf-8')
        line = f.readlines()
    except UnicodeError:
        print('not utf-8, trying utf 16')
        try:
            f = codecs.open(filename, encoding='utf-16')
            line = f.readlines()
        except UnicodeError:
            print('not utf-16, trying gbk')
            try:
                f = codecs.open(filename, encoding='gbk')           
                line = f.readlines()
            except UnicodeError:
                print('not gbk, try unicode')
                f = open(filename)
                line = f.readlines()
    return line

def save(filename, string):
    save_to = codecs.open(filename, 'w')
    save_to.write(string)

def grammarTestKeywords(keywords, saveFile):
    testPassCount = 0.0
    testCaseCount = len(keywords)
    results = []

    for keyword in keywords:
        keyword = keyword.strip()
        url = 'http://yufa/api/s/' + keyword
        
        response = requests.get(url)
        soup = BeautifulSoup(response.content, 'lxml')
        rows = soup('p')
        for row in rows:
            print row.text
            if len(row.text) > 0:
                if row.text == 'The URI you submitted has disallowed characters.':
                    print keyword
                else:
                    print row.text
                    # resultString = row.text.encode("utf-8")
                    resultString = row.text
                    if resultString.startswith('Test Passed!'):
                        testPassCount += 1
                    # else:
                        # testFailed = "Test Failed for keyword [%s]" % keyword
                    results.append(resultString)


    testPassRate = 100 * testPassCount / testCaseCount
    testPassRateString = '%.2f %%' % testPassRate

    divider = "="*70
    results.sort()
    results.insert(0, 'Tested [%d] testcases, test passed [%d] cases, testPassRate = [%s] %s' % (testCaseCount, testPassCount, testPassRateString, divider) )

    resultString = "\n".join(results).encode("utf-8")
    save(saveFile, resultString)

    return (testPassCount, testCaseCount, testPassRateString, results)


# pick one keyword out of each keywords and put together

def makeKeywords(aWords, bWords):

    keywords = []

    import random

    lenA = len(aWords)
    lenB = len(bWords)

    indexA = random.randint(0,lenA-1)
    indexB = random.randint(0,lenB-1)


    shuffle(aWords)
    shuffle(bWords)

    if lenA > lenB:
        print ''
        for a in aWords[:lenA]:
            keyword = ",".join([a.strip(), bWords[indexB].strip()])
            keywords.append(keyword)
    else:
        for b in bWords[:lenB]:
            keyword = ",".join([aWords[indexA].strip(), b.strip()])
            keywords.append(keyword)

    return keywords


def testSuit(testName, aWords = [], bWords = [], xxKeywordsExclusive = []):
    xxKeywords = xxKeywordsExclusive
    logFilePath = 'results/%s.txt' % testName

    if len(xxKeywords) == 0:
        xxKeywords = makeKeywords(aWords, bWords)

    testPassCount, testCaseCount, testPassRate, results = grammarTestKeywords(xxKeywords, logFilePath)

    resultString = 'Testing %s with [%d] testcases, test passed [%d] cases, testPassRate = [%s]' % (testName, testCaseCount, testPassCount, testPassRate)
    return resultString

if __name__ == '__main__':
    enKeywords = read('keywords/en.txt')
    cnKeywords = read('keywords/cn.txt')

    print "==== testing ... ===="
    # testSuit('enKeywords', xxKeywordsExclusive = enKeywords)
    testSuit('cnKeywords', xxKeywordsExclusive = cnKeywords)
    '''
    testSuit('eeKeywords', enKeywords, enKeywords)
    testSuit('ceKeywords', cnKeywords, enKeywords)
    testSuit('ecKeywords', enKeywords, cnKeywords)
    testSuit('ccKeywords', cnKeywords, cnKeywords)
    '''

    # print pythonVersion()