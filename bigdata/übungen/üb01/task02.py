import numpy as np
import matplotlib.pyplot as plt
import collections as coll


def plothisto(pages, binnum, title, filename):
	plt.figure()
	plt.hist(pages, bins=binnum)
	plt.title(title)
	plt.xlabel('Page Length')
	plt.ylabel('Publications')
	plt.grid(axis='y')
	plt.savefig(filename)
	plt.show()
	plt.close()


def printstats(pages, count):
	print("Count: " + str(count))
	print("Min: " + str(np.min(pages)))
	print("Max: " + str(np.max(pages)))
	print("Lower Quartile: " + str(np.quantile(pages, .25)))
	print("Upper Quartile: " + str(np.quantile(pages, .75)))
	print("Median: " + str(np.median(pages)))
	print("Mean: " + str(np.mean(pages)))


if __name__ == '__main__':

	upperlimit = 50
	lowerlimit = 1
	binnum = 100

	pagefile = open("pages.csv", mode="r")
	lines = pagefile.readlines()
	pages = np.empty(len(lines) - 1)

	for i in range(0, len(lines) - 1):
		line = lines[i + 1].split(",")
		if i == 0:
			continue
		else:
			pages[i] = int(line[2]) - int(line[1]) + 1
	plothisto(pages, binnum, 'Unfiltered Data', 'task02hist01.png')
	print("======= Unfiltered =======")
	printstats(pages, len(pages))

	filtered = []
	count = 0
	for page in pages:
		if page > upperlimit:
			count = count + 1
			continue
		else:
			filtered.append(page)
	pages = np.copy(filtered)
	plothisto(pages, binnum, 'Filtered Upper Limit', 'task02hist02.png')
	print("======= Filter > " + str(upperlimit) + " =======")
	printstats(pages, count)

	filtered = []
	count = 0
	for page in pages:
		if page < lowerlimit:
			count = count + 1
			continue
		else:
			filtered.append(page)
	pages = np.copy(filtered)
	plothisto(pages, binnum, 'Filtered Lower Limit', 'task02hist03.png')
	print("======= Filter < " + str(lowerlimit) + " =======")
	printstats(pages, count)
