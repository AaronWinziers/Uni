#!/usr/bin/env python
# -*- coding: utf-8 -*-

import math


def calcnr(rels):
	n = 0
	r = 0
	for x in rels:
		if x == 0:
			n += 1
		elif x == 1:
			r += 1
	print(n, r)
	return n, r


def bpref(rels, n, r):
	val = 0
	prev = 0
	for x in rels:
		if x == 1:
			val += 1 - (prev / min(n, r))
			print("val: ", val)
		elif x == 0 & prev <= r:
			prev += 1
			print("prev: ", prev)
	val /= r
	print("result: ", val)
	return val


def main():
	""" Main program """

	rel1 = [1, 0, 0, 1, 1, 0, 0, 1, 1, 0]
	rel2 = [1, 0, -1, 1, 1, 0, -1, 1, 1, 0]

	N, R = calcnr(rel1)
	bpref1 = bpref(rel1, N, R)
	print("BPREF aufgabe c: ", bpref1)

	N, R = calcnr(rel2)
	bpref2 = bpref(rel2, N, R)
	print("BPREF aufgabe d: ", bpref2)


if __name__ == "__main__":
	main()
