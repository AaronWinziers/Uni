"""Aaron Winziers"""
import numpy
import math

R = numpy.array([[0.5, 0.34], [0.78, 0.54]])
G = numpy.array([[0.8, 0.0], [0.23, 0.76]])
B = numpy.array([[0.99, 0.12], [0.12, 1.0]])
Q = numpy.array([[16, 11], [12, 12]])
q = 0.5
n = len(R)
N = range(n)


def toYUV(r, g, b):
    n = len(r)
    y = numpy.zeros((n, n))
    u = numpy.zeros((n, n))
    v = numpy.zeros((n, n))

    for i in N:
        for j in N:
            y[i, j] = 0.299 * r[i, j] + 0.587 * g[i, j] + 0.114 * b[i, j]
            u[i, j] = (b[i, j] - y[i, j]) * 0.493
            v[i, j] = (r[i, j] - y[i, j]) * 0.877
    return y, u, v


def prepare(y, u, v):
    for i in N:
        for j in N:
            y[i, j] = round(y[i, j] * 255) - 128
            u[i, j] = round((u[i, j] + 0.436) * 255 / 0.872) - 128
            v[i, j] = round((v[i, j] + 0.615) * 255 / 1.23) - 128
    return y, u, v


def dct(y, u, v):
    def cosine(c, d):
        return math.cos((((2 * c) + 1) * d * math.pi) / (2 * n))

    def c(num):
        if num == 0:
            return 1 / math.sqrt(2)
        else:
            return 1

    def factor(x, z):
        return (2 * c(x) * c(z)) / n

    def calc(x, z):
        result = numpy.zeros(3)

        for i in N:
            inside = numpy.zeros(3)
            for j in N:
                inside[0] += y[i, j] * cosine(i, x) * cosine(j, z)
                inside[1] += u[i, j] * cosine(i, x) * cosine(j, z)
                inside[2] += v[i, j] * cosine(i, x) * cosine(j, z)
            for add in range(3):
                result[add] += inside[add]

        fact = factor(x, z)
        result = [x * fact for x in result]

        return result[0], result[1], result[2]

    n = len(y)
    fy = numpy.zeros((n, n))
    fu = numpy.zeros((n, n))
    fv = numpy.zeros((n, n))

    for x in N:
        for z in N:
            fy[x, z], fu[x, z], fv[x, z] = calc(x, z)

    return fy, fu, fv


def quantize(y, u, v):
    newQ = Q
    for x in N:
        for z in N:
            newQ[x, z] *= q
    for i in N:
        for j in N:
            y[i, j] = round(y[i, j] / newQ[i, j])
            u[i, j] = round(u[i, j] / newQ[i, j])
            v[i, j] = round(v[i, j] / newQ[i, j])
    return y, u, v


def dequantize(y, u, v):
    newQ = Q
    for x in N:
        for z in N:
            newQ[x, z] *= q
    for i in N:
        for j in N:
            y[i, j] = y[i, j] * newQ[i, j]
            u[i, j] = u[i, j] * newQ[i, j]
            v[i, j] = v[i, j] * newQ[i, j]
    return y, u, v


def idct(y, u, v):
    def cosine(c, d):
        return math.cos((((2 * c) + 1) * d * math.pi) / (2 * n))

    def c(num):
        if num == 0:
            return 1 / math.sqrt(2)
        else:
            return 1

    def factor(x, z):
        return (2 * c(x) * c(z)) / n

    def calc(i, j):
        result = numpy.zeros(3)

        for x in N:
            inside = numpy.zeros(3)
            for z in N:
                fact = factor(x, z)
                inside[0] += fact * y[x, z] * cosine(i, x) * cosine(j, z)
                inside[1] += fact * u[x, z] * cosine(i, x) * cosine(j, z)
                inside[2] += fact * v[x, z] * cosine(i, x) * cosine(j, z)
            for add in range(3):
                result[add] += inside[add]

        return result[0], result[1], result[2]

    fy = numpy.zeros((n, n))
    fu = numpy.zeros((n, n))
    fv = numpy.zeros((n, n))

    for i in N:
        for j in N:
            fy[i, j], fu[i, j], fv[i, j] = calc(i, j)

    return fy, fu, fv


Y, U, V = toYUV(R, G, B)
fY, fU, fV = prepare(Y, U, V)
FY, FU, FV = dct(fY, fU, fV)
FQY, FQU, FQV = quantize(FY, FU, FV)
dFQY, dFQU, dFQV = dequantize(FQY, FQU, FQV)
dFQY, dFQU, dFQV = idct(dFQY, dFQU, dFQV)

print("Old, New")
for i in N:
    for j in N:
        print("[" + str(i) + ", " + str(j) + "]")
        print("    " + str(fY[i, j]) + ", " + str(dFQY[i, j]))
        print("    " + str(fU[i, j]) + ", " + str(dFQU[i, j]))
        print("    " + str(fV[i, j]) + ", " + str(dFQV[i, j]))
print("")
print("Die Endwerte sind alle ungefaehr halb so gross wie Ursprungswerte. Dieser Wertunterschied ist ein Beispiel der Komperssionsartefakten die bei starker Datenkompression auftreten")