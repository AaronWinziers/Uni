#!/usr/bin/env python
# -*- coding: utf-8 -*-

import math


def printtex(y):
	for x in y:
		print("& ", x, "	", end="")


def mndcg(ndcg1, ndcg2):
	vals = []
	for x in range(10):
		vals.append((ndcg1[x]+ndcg2[x])/2)
	return vals


def normalize(dcg, ideal):
	vals = []
	for x in range(10):
		vals.append(dcg[x]/ideal[x])
	return vals


def dcg(ranks):
	vals = []
	vals.append(ranks[0])
	for x in range(9):  # x+2
		rank = x + 2
		vals.append(vals[x] + (ranks[x+1]/math.log(rank, 2)))
	return vals


def main():
	""" Main program """
	# Code goes over here.

	docs = ["a", "e", "g", "b", "p", "c", "j", "h", "r", "d"]

	ranks1 = [2, 0, 0, 2, 0, 1, 0, 0, 0, 1]
	ranks2 = [2, 0, 1, 0, 1, 0, 0, 0, 0, 0]

	ideal = [2, 2, 1, 1, 0, 0, 0, 0, 0, 0]

	dcg1 = dcg(ranks1)
	dcg2 = dcg(ranks2)
	dcgi = dcg(ideal)

	print("Aufgabe 1 DCG: ", dcg1)
	print("Aufgabe 2 DCG: ", dcg2)
	print("Ideal:", dcgi)

	ndcg1 = normalize(dcg1, dcgi)
	ndcg2 = normalize(dcg2, dcgi)

	print("Aufgabe 1 nDCG: ", ndcg1)
	print("Aufgabe 2 nDCG: ", ndcg2)

	aufgabe3 = mndcg(ndcg1, ndcg2)

	print("NDCG1")
	printtex(ndcg1)
	print("")
	print("NDCG2")
	printtex(ndcg2)
	print("")
	print("IDEAL")
	printtex(dcgi)
	print("")
	print("AUFGABE 3")
	printtex(aufgabe3)



if __name__ == "__main__":
	main()
