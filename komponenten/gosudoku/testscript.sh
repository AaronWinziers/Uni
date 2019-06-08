#!/bin/sh

screen -dmS field1 go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_A1 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku1.txt -telegramtoken=648612807:AAGOVvhv6UQyYiZecpzGmtL18JhhXNVnzqg
screen -dmS field2 go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_D1 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku2.txt -telegramtoken=773694483:AAHTXYimkAMgJlmBBqlkutz7e-1MmmqSPn8
screen -dmS field3 go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_G1 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku3.txt -telegramtoken=671641632:AAFht6y6Z1mZIFFPrlZsPPEP658zqKkie5I
screen -dmS field4 go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_A4 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku4.txt -telegramtoken=748119613:AAGs-0XwGgwUYWsOJcteuKhogbekIG0SPnQ
screen -dmS field5 go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_D4 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku5.txt -telegramtoken=673313567:AAF-4LyyAcT6pTLO-c6q590h9AuGwnp5E5U
screen -dmS field6 go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_G4 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku6.txt -telegramtoken=786901164:AAHoeXedQ9GKnuabYMMwTY95edmhLEEREVo
screen -dmS field7 go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_A7 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku7.txt -telegramtoken=682420506:AAFVkYwHzcMKOQgpbfUlPvceCqJ9TD7SOxw
screen -dmS field8 go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_D7 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku8.txt -telegramtoken=612894313:AAHF2XkJBLQ7kqqLw8wi4I_8ylVd8lsYffs
go run cmd/sudokuSolver/sudokuSolver.go -boxID=BOX_G7 -maddress=127.0.0.1 -mport=4242 -input=./example/sudoku9.txt -telegramtoken=747163696:AAECvpkingsd52z3pn_GgtQ633_uWeYVDaU