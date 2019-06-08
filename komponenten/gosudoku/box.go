package gosudoku

import (
	"fmt"
	"log"
	"strconv"
	"strings"
)

type box struct {
	id             string
	values         [9]int
	setValues      int
	possibleValues [9]map[int]struct{}
	rowValues      [3][]int // Stores all values which are set in a whole row (includes values from other boxConnections)
	colValues      [3][]int // Stores all values which are set in a whole column (includes values from other boxConnections)
	boxFinished    bool
}

var Done = make(chan int)

// Initializes the field configuration from a given string
// Format: xy:v with x between 0 and 2 (column) and y between 0 and 2 (row) and value v, separated by comma
func (b *box) initializeBox(boxID *string, fieldString string) {
	b.id = *boxID
	log.Println("Reading input configuration...")
	config := strings.Split(fieldString, ",")
	for _, el := range config {
		x, y, v := readFieldConfigStr(el)
		b.setFieldValue(x, y, v)
		b.setValues += 1
	}

	// Set initial possible values
	for field, value := range b.values {
		if value == 0 {
			b.possibleValues[field] = make(map[int]struct{})
			for i := 1; i < 10; i++ {
				if !intContains(b.values[:], i) {
					b.possibleValues[field][i] = struct{}{}

				}
			}
		}
	}
}

// Set field value via coordinates
func (b *box) setFieldValue(x, y, v int) {
	// Matrix conversion, see: https://stackoverflow.com/a/14015582
	b.values[x+y*3] = v
}

// Set field value via coordinates
func (b *box) getFieldValue(x, y int) int {
	return b.values[x+y*3]
}

//Helper function to return coordinates from index
func getCoordinatesForIndex(index int) (int, int) {
	return index % 3, index / 3
}

// Set row value
func (b *box) setRowValue(ycoord int, val int) {
	b.rowValues[ycoord] = append(b.rowValues[ycoord], val)
	for i := 0; i < 3; i++ {
		index := ycoord*3 + i
		b.removeFromPossibleValues(index, val)
	}
}

// Set column value
func (b *box) setColValue(xcoord int, val int) {
	b.colValues[xcoord] = append(b.colValues[xcoord], val)
	for i := 0; i < 3; i++ {
		index := xcoord + i*3
		b.removeFromPossibleValues(index, val)
	}
}

// Check and set possible values
func (b *box) checkAndSet(index int) {
	if len(b.possibleValues[index]) == 1 {
		var val int
		for key := range b.possibleValues[index] {
			val = key
			delete(b.possibleValues[index], key)
		}
		log.Println("Setting value at pos: " + strconv.Itoa(index) + " to: " + strconv.Itoa(val))
		b.values[index] = val
		b.setValues += 1
		b.removeFromAllPossibleValues(val)
		x, y := getCoordinatesForIndex(index)
		sendUpdate(x, y, val)
		if !b.boxFinished && b.completed() {
			b.boxFinished = true
			sendReady()
			log.Println("Box is finished.")
			drawResultBox()
			Done <- 1
		}
	}
}

// Removes value from possible values from all field
func (b *box) removeFromPossibleValues(index, val int) {
	if b.values[index] == 0 {
		if _, ok := b.possibleValues[index][val]; ok {
			delete(b.possibleValues[index], val)
			b.checkAndSet(index)
		}
	}
}

// Removes value from all possible values of myBox
func (b *box) removeFromAllPossibleValues(val int) {
	for index := range b.values {
		b.removeFromPossibleValues(index, val)
	}
}

// checks if box is filled out completely
func (b *box) completed() bool {
	return b.setValues == 9
}

// Draws box for pretty output
func (b *box) getResultBoxString() string {
	var result string
	result = fmt.Sprintf("%s:\n", b.id)
	result = fmt.Sprintf("╭─────┬─────┬─────╮\n")
	result += fmt.Sprintf("│     %d     │     %d     │     %d     │\n", b.getFieldValue(0, 0), b.getFieldValue(1, 0), b.getFieldValue(2, 0))
	result += fmt.Sprintf("├─────┼─────┼─────┤\n")
	result += fmt.Sprintf("│     %d     │     %d     │     %d     │\n", b.getFieldValue(0, 1), b.getFieldValue(1, 1), b.getFieldValue(2, 1))
	result += fmt.Sprintf("├─────┼─────┼─────┤\n")
	result += fmt.Sprintf("│     %d     │     %d     │     %d     │\n", b.getFieldValue(0, 2), b.getFieldValue(1, 2), b.getFieldValue(2, 2))
	result += fmt.Sprintf("╰─────┴─────┴─────╯\n")
	return result
}
