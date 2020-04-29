import csv

if __name__ == '__main__':
	minpages = -1
	maxpages = -1
	total = 0
	count = 0
	negcount = 0

	with open("pages.csv", mode="r") as pagefile:
		lines = pagefile.readlines()
		print(lines[0])
		for i in range(1, len(lines)):
			line = lines[i].split(",")
			pages = int(line[2]) - int(line[1]) + 1
			if i == 1:
				minpages = pages
				maxpages = pages
			minpages = min(minpages, pages)
			maxpages = max(maxpages, pages)
			total = total + pages
			count = count + 1
	print("max: " + str(maxpages))
	print("min: " + str(minpages))
	print("total: " + str(total))
	print("avg: " + str(round(total / count)))

