package gosudoku

import (
	"github.com/yanzay/tbot"
	"log"
	"regexp"
	"strconv"
)

const GROUPID = -1001457965485 // CHANNEL ID

var foreignBoxRegEx = regexp.MustCompile(`^(BOX_[A,D,G][1,4,7]),([0-2]),([0-2]):([1-9])$`)

var bot *tbot.Server

var connectedCh = make(chan bool)
var startCh = make(chan bool)
var connected = false
var start = false

func StartTelegramBot(token string) {
	var err error

	log.Println("Initializing Telegram Bot!")

	// Create new telegram bot server using token
	bot, err = tbot.NewServer(token)
	checkErr(err)

	bot.HandleFunc("/fieldconfig {fieldconfig}", FieldConfigHandler)
	bot.HandleFunc("/start", StartHandler)
	//bot.HandleDefault(DefaultHandler)

	connectedCh <- true

	err = bot.ListenAndServe()
	checkErr(err)
}

func FieldConfigHandler(message *tbot.Message) {
	fieldConfig := message.Vars["fieldconfig"]
	readFieldConfiguration(fieldConfig)
}

func StartHandler(message *tbot.Message) {
	log.Println("Start solving Sudoku...")
	start = true
	startCh <- true
}

func sendMessage(message string) {
	err := bot.Send(GROUPID, message)
	checkErr(err)
}

func sendFieldConfiguration() {
	if !connected {
		<-connectedCh // Wait until Server is started
		<-startCh     // Wait for start signal
		connected = true
	}

	for key, val := range myBox.values {
		if val != 0 {
			x, y := getCoordinatesForIndex(key)
			sendMessage("/fieldconfig " + myBox.id + "," + strconv.Itoa(x) + "," + strconv.Itoa(y) + ":" + strconv.Itoa(val))
		}
	}

}

func sendReady() {
	result := "/ready " + myBox.id
	for _, val := range myBox.values {
		result += "," + strconv.Itoa(val)
	}
	sendMessage(result)
}

func sendUpdate(x, y, val int) {
	sendMessage("/fieldconfig " + myBox.id + "," + strconv.Itoa(x) + "," + strconv.Itoa(y) + ":" + strconv.Itoa(val))
}

func readFieldConfiguration(fieldConfig string) {
	if start {
		var isColumn = false
		var isRow = false

		if foreignBoxRegEx.MatchString(fieldConfig) {
			matches := foreignBoxRegEx.FindStringSubmatch(fieldConfig)
			foreignBoxID := matches[1]

			log.Println("Received fieldConfiguration from " + foreignBoxID)

			if foreignBoxID[:len(matches[1])-1] == myBox.id[:len(myBox.id)-1] {
				isColumn = true
			} else if foreignBoxID[len(matches[1])-1:] == myBox.id[len(myBox.id)-1:] {
				isRow = true
			}

			if isRow || isColumn { // Otherwise it's a box which doesn't affect us.
				val, err := strconv.Atoi(matches[4])
				checkErr(err)
				if isColumn {
					x, err := strconv.Atoi(matches[2])
					checkSoftErr(err)
					myBox.setColValue(x, val)
				} else {
					y, err := strconv.Atoi(matches[3])
					checkSoftErr(err)
					myBox.setRowValue(y, val)
				}
			}
		}
	}
}

func drawResultBox() {
	err := bot.Send(GROUPID, myBox.getResultBoxString())
	checkSoftErr(err)
}
