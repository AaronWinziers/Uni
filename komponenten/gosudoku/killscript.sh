#!/bin/sh

screen -S boxmanager -X quit
screen -S field1 -X quit
screen -S field2 -X quit
screen -S field3 -X quit
screen -S field4 -X quit
screen -S field5 -X quit
screen -S field6 -X quit
screen -S field7 -X quit
screen -S field8 -X quit
screen -S field9 -X quit

pkill -f sudokuSolver
pkill -f boxmanager