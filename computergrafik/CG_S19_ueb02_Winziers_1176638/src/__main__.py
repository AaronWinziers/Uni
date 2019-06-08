#!/usr/bin/env python
# -*- coding: utf-8 -*-

import pygame
import numpy


def bresenham(a, b):
    dx = abs(b[0] - a[0])
    dy = abs(b[1] - a[1])
    s1 = numpy.sign(b[0] - a[0])
    s2 = numpy.sign(b[1] - a[1])
    y = a[1]
    x = a[0]

    if dy > dx:
        t = dx
        dx = dy
        dy = t
        switched = True
    else:
        switched = False

    e = 2 * dy - dx
    c = 2 * dy
    d = 2 * dy - 2 * dx

    lit = []

    lit.append([x, y])

    for num in range(dx):
        if e < 0:
            if switched:
                y = y + s2
            else:
                x = x + s1
            e = e + c
        else:
            y = y + s2
            x = x + s1
            e = e + d
        lit.append([x, y])

    print(lit)
    return lit


def draw_lines(line, grid, origin):
    for pixel in line:
        pygame.draw.rect(grid, (255, 255, 255), [origin[0] + pixel[0] * 10, origin[1] - pixel[1] * 10, 10, 10])

    pygame.display.update()


def main():
    """ Main program """
    # Code goes over here.

    p0 = [0, 0]
    points = [
        [15, 35],
        [35, 15],
        [15, -35],
        [35, -15],
        [-15, -35],
        [-35, -15],
        [-15, 35],
        [-35, 15]
    ]

    # maxx = max(abs(p0[0]), abs(p2[0]))
    # maxy = max(abs(p0[1]), abs(p2[1]))
    maxx = 50
    maxy = 50

    origin = [maxx * 10 + 1, maxy * 10 + 1]

    width = maxx * 10 * 2 + 1
    height = maxy * 10 * 2 + 1

    grid = pygame.display.set_mode([width, height])

    for x in points:
        draw_lines(bresenham(p0, x), grid, origin)

    for x in range(100):
        pygame.draw.rect(grid, (169, 169, 169), [x * 10, origin[1], 10, 10])
        pygame.draw.rect(grid, (169, 169, 169), [origin[0], x * 10, 10, 10])

    pygame.display.update()

    running = True
    while running:
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                running = False


if __name__ == "__main__":
    main()
