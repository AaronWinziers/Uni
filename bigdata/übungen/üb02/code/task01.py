import numpy as np


def rec(po, p):
	return po / p


def calcc(dict):
	result = 0
	for key in dict.keys():
		num = len(dict[key])
		result = result + ((num * (num - 1)) / 2)
	return result


def save(dict, n):
	c = calcc(dict)
	save = 1 - (c / ((n * (n - 1)) / 2))

	return save


if __name__ == '__main__':

	file = open("dblp_names.csv")
	lines = file.readlines()
	lines.pop(0)
	pair = []

	first = {}
	last = {}

	pfirst = 0
	plast = 0

	for line in lines:
		vals = line.rstrip().split(",")
		if len(vals) != 2:
			continue
		pair.append(vals)

		for name in vals:
			parts = name.split()
			given = parts[0]
			surname = parts[len(parts) - 1]
			if given in first.keys():
				first[given].append(name)
			else:
				first[given] = []
				first[given].append(name)
			if surname in last.keys():
				last[surname].append(name)
			else:
				last[surname] = []
				last[surname].append(name)

		if vals[0].split()[0] == vals[1].split()[0]:
			pfirst = pfirst + 1

		# Please don't judge my laziness
		if vals[0].split()[len(vals[0].split()) - 1] == vals[1].split()[len(vals[1].split()) - 1]:
			plast = plast + 1

	pairs = len(pair)
	print(pairs)

	print("=====First Name Block=====")
	print("Number of keys: " + str(len(first.keys())))
	print("Rec(first) = " + str(rec(pfirst, pairs)))
	print("C(first) = " + str(calcc(first)))
	print("Save(first) = " + str(save(first, pairs * 2)))
	print()
	print("=====Last Name Block=====")
	print("Number of keys: " + str(len(last.keys())))
	print("Rec(last) = " + str(rec(plast, pairs)))
	print("C(last) = " + str(calcc(last)))
	print("Save(last) = " + str(save(last, pairs * 2)))

	print(pow(pairs, 2))
