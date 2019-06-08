package main

import (
	"flag"
	"fmt"
	"github.com/michaelwolz/gosudoku"
	"os"
)

var (
	initialConfig string
	boxID         string
)

var Done = make(chan int)

// Initializes flag configuration
func init() {
	flag.StringVar(&initialConfig, "initialConfig", "", "Input Sudoku field")
	flag.StringVar(&boxID, "boxID", "", "Box Number")
}

// Usage: sudokuSolver -initialConfig={INITIALCONFIG} -boxID={BOXNUMBER}
func main() {
	flag.Parse()

	if len(initialConfig) == 0 {
		fmt.Println("-initialConfig option is missing! You have to provide a Sudoku field configuration.")
		os.Exit(1)
	}

	if boxID == "" {
		fmt.Println("-boxID option is missing!")
		os.Exit(1)
	}

	go gosudoku.StartTelegramBot(gosudoku.TToken[boxID])
	gosudoku.InitializeSudoku(initialConfig, &boxID)

	<-gosudoku.Done
}