#!/usr/bin/python

import re

test1 = "Programmers will often write hello world as their first project with a programming language."
test2 = "The gooey peanut butter and jelly sandwich was a beauty."
test3 = "AA312, AA1298, NW1234, US443, US31344"

def find_all_hw(test):
	regex = re.compile(r"\bhello world\b")
        return regex.findall(test)

def find_all_tv(test):
	regex = re.compile(r"\b[aeiou]{3}[\w]+|[\w]+[aeiou]{3}[\w]+|[\w]+[aeiou]{3}|[aeiou]{3}\b")
	return regex.findall(test)

def find_all_fc(test):
	regex = re.compile(r"\b[A-Z]{2}\d{3,4}\b")
	return regex.findall(test)

print(find_all_hw(test1))
print(find_all_tv(test2))
print(find_all_fc(test3))
