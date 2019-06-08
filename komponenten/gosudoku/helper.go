package gosudoku

import (
	"log"
	"strconv"
)

func checkErr(err error) {
	if err != nil {
		panic(err)
	}
}

func checkSoftErr(err error) {
	if err != nil {
		log.Println(err)
	}
}

// Check if int array strContains specific int
func intContains(haystack []int, needle int) bool {
	for _, x := range haystack {
		if x == needle {
			return true
		}
	}
	return false
}

// Returns x,y-Coordinates and value from a fieldConfig-String
func readFieldConfigStr(config string) (int, int, int) {
	x, err := strconv.Atoi(string(config[0]))
	y, err := strconv.Atoi(string(config[1]))
	v, err := strconv.Atoi(string(config[3]))
	checkSoftErr(err)
	return x, y, v
}

// Telegram Token
// ICH WEIß, DASS DIE NICHT INS ÖFFENTLICHE GIT SOLLTEN! IST MIR ABER EGAL. NACH DEM PROJEKT WERDEN DIE BOTS GELÖSCHT
var TToken = map[string]string{
	"box_a1": "648612807:AAGOVvhv6UQyYiZecpzGmtL18JhhXNVnzqg",
	"box_a4": "773694483:AAHTXYimkAMgJlmBBqlkutz7e-1MmmqSPn8",
	"box_a7": "671641632:AAFht6y6Z1mZIFFPrlZsPPEP658zqKkie5I",
	"box_d1": "748119613:AAGs-0XwGgwUYWsOJcteuKhogbekIG0SPnQ",
	"box_d4": "673313567:AAF-4LyyAcT6pTLO-c6q590h9AuGwnp5E5U",
	"box_d7": "786901164:AAHoeXedQ9GKnuabYMMwTY95edmhLEEREVo",
	"box_g1": "682420506:AAFVkYwHzcMKOQgpbfUlPvceCqJ9TD7SOxw",
	"box_g4": "612894313:AAHF2XkJBLQ7kqqLw8wi4I_8ylVd8lsYffs",
	"box_g7": "747163696:AAECvpkingsd52z3pn_GgtQ633_uWeYVDaU",
}
