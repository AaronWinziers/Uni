import numpy
import pygame


def rotate(q, angle, axis):
	rad = numpy.deg2rad(angle)
	if axis == "x":
		turn = numpy.array([[1, 0, 0], [0, numpy.cos(rad), -numpy.sin(rad)], [0, numpy.sin(rad), numpy.cos(rad)]])
	elif axis == "y":
		turn = numpy.array([[numpy.cos(rad), 0, numpy.sin(rad)], [0, 1, 0], [-numpy.sin(rad), 0, numpy.cos(rad)]])
	elif axis == "z":
		turn = numpy.array([[numpy.cos(rad), -numpy.sin(rad), 0], [numpy.sin(rad), numpy.cos(rad), 0], [0, 0, 1]])
	else:
		print("Send a proper axis please")
		return

	for i in range(len(q)):
		q[i] = turn.dot(q[i])

	return q


def translate(q, shift):
	for i in range(len(q)):
		for j in range(3):
			q[i][j] += shift[j]

	return q


# noinspection SpellCheckingInspection
def project(q, d):
	projection = []
	for i in q:
		u = (i[0] * d) / (i[2] + d)
		v = (i[1] * d) / (i[2] + d)

		projection.append([u, v])

	return projection


def main():
	quader = numpy.array([[0.0, 0, 0], [1, 0, 0], [1, 2, 0], [0, 2, 0], [0, 0, 3], [1, 0, 3], [1, 2, 3], [0, 2, 3]])
	for i in quader:
		print(i)
	print("------------------------------------------")
	quader = rotate(quader, 30, "z")
	for i in quader:
		print(i)
	print("------------------------------------------")
	shift = numpy.array([3, 2, 0])
	quader = translate(quader, shift)
	for i in quader:
		print(i)
	print("------------------------------------------")
	projection = project(quader, 6)
	for i in projection:
		print(i)


if __name__ == "__main__":
	main()
