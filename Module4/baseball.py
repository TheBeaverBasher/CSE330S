#!/usr/bin/python

import operator
import os
import re
import sys
import urllib2

if len(sys.argv) < 2:
	while True:
		year = int(raw_input("What year's stats would you like to view? "))
		if year == 1930:
			url1930 = "http://classes.engineering.wustl.edu/cse330/content/cardinals/cardinals-1930.txt"
			stats = urllib2.urlopen(url1930).read()
			break
		if year == 1940:
			url1940 = "http://classes.engineering.wustl.edu/cse330/content/cardinals/cardinals-1940.txt"
			stats = urllib2.urlopen(url1940).read()
			break
		if year == 1941:
			url1941 = "http://classes.engineering.wustl.edu/cse330/content/cardinals/cardinals-1941.txt"
			stats = urllib2.urlopen(url1941).read()
			break
		if year == 1942:
			url1942 = "http://classes.engineering.wustl.edu/cse330/content/cardinals/cardinals-1942.txt"
			stats = urllib2.urlopen(url1942).read()
			break
		if year == 1943:
			url1943 = "http://classes.engineering.wustl.edu/cse330/content/cardinals/cardinals-1943.txt"
			stats = urllib2.urlopen(url1943).read()
			break
		if year == 1944:
			url1944 = "http://classes.engineering.wustl.edu/cse330/content/cardinals/cardinals-1944.txt"
			stats = urllib2.urlopen(url1944).read()
			break
		print "That's not a year we have, try again..."
		
else:
	filename = sys.argv[1]
	if not os.path.exists(filename):
		sys.exit("Error: File '%s' not found" % sys.argv[1])
	stats = open(filename).read()

class player:
	def __init__(self, firstname, lastname):
		self.name = firstname+" "+lastname
		self.gamesPlayed = 0
		self.atBat = 0
		self.hits = 0
		self.runs = 0	
	def addGame(self):
		self.gamesPlayed += 1	
	def addAtBat(self, x):
		self.atBat += x
	def addHits(self, x):
		self.hits += x
	def addRuns(self, x):
		self.runs += x
	def getAVG(self):
		if self.atBat == 0:
			return 0
		else:
			return self.hits/self.atBat


class roster:
	def __init__(self):
		self.players = []
	def addPlayer(self, firstname, lastname):
		self.players.append(player(firstname, lastname))
	def updateStats(self, firstname, lastname, bat, hit, run):
		onRoster = False
		for x in self.players:
			if x.name == firstname+" "+lastname:
				x.addGame()
				x.addAtBat(bat)
				x.addHits(hit)
				x.addRuns(run)
				onRoster = True
				break
		if onRoster:
			return
		else:
			self.addPlayer(firstname, lastname)
			self.updateStats(firstname, lastname, bat, hit, run)
		

def yearStats(file):
	playerex = re.compile(r"\b(\w+)+\s+(\w+)+\s+batted+\s+(\d)+\s+times+\s+with+\s+(\d)+\s+hits+\s+and+\s+(\d)+\s+runs\b")
	stats = playerex.findall(file)
	cards = roster()
	for x in stats:
		cards.updateStats(x[0], x[1], float(x[2]), float(x[3]), float(x[4]))
	cards.players.sort(key=operator.methodcaller("getAVG"),reverse=True)
	for y in cards.players:
		print y.name + ": %.3f" %y.getAVG()
		
yearStats(stats)
