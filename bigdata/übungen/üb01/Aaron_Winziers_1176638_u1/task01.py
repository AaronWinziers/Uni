import numpy as np
import matplotlib.pyplot as plt

if __name__ == '__main__':

	pagefile = open("pages.csv", mode="r")
	lines = pagefile.readlines()
	pages = np.empty(len(lines) - 1)

	for i in range(0, len(lines) - 1):
		line = lines[i + 1].split(",")
		if i == 0:
			continue
		else:
			pages[i] = int(line[2]) - int(line[1]) + 1

	pages = np.sort(pages)
	print(len(pages))

	for i in range(0, len(pages)):
		if pages[i] == 1:
			print(i)
			break

	for i in range(0, len(pages)):
		if pages[i] > 200:
			print(i)
			break

	plt.figure(figsize=(10, 2))
	plt.boxplot(pages, sym="r+", whis=(5, 95), vert=False)
	plt.show()

	print("Min: " + str(np.min(pages)))
	print("Max: " + str(np.max(pages)))
	print("Lower Quartile: " + str(np.quantile(pages, .25)))
	print("Upper Quartile: " + str(np.quantile(pages, .75)))
	print("Median: " + str(np.median(pages)))
	print("Mean: " + str(np.mean(pages)))
