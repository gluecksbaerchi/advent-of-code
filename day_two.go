// advent_of_code project main.go
package main

import (
	"bufio"
	"fmt"
	"os"
	//"strings"
)

func main() {
	fmt.Println("Hello World!")

	readFile, err := os.Open("day_two_input.txt")

	if err != nil {
		fmt.Println(err)
	}
	fileScanner := bufio.NewScanner(readFile)

	fileScanner.Split(bufio.ScanLines)

	// Rock defeats Scissors, Scissors defeats Paper, and Paper defeats Rock
	// A for Rock, B for Paper, and C for Scissors
	// X for Rock, Y for Paper, and Z for Scissors
	// A defeats C, C defeats B, and B defeats A

	shapeScore := map[string]int{
		"A": 1,
		"B": 2,
		"C": 3,
	}

	lost := 0
	draw := 3
	win := 6

	currentscore := 0
	score := 0
	for fileScanner.Scan() {
		currentscore = 0
		line := fileScanner.Text()
		opponent := string(line[0])
		me := string(line[2])
		fmt.Println(opponent + " " + me)

		if me == "X" {
			// lose
			switch opponent {
			case "A":
				currentscore = lost + shapeScore["C"]
			case "B":
				currentscore = lost + shapeScore["A"]
			case "C":
				currentscore = lost + shapeScore["B"]
			}
		} else if me == "Y" {
			// draw
			currentscore = draw + shapeScore[opponent]
		} else if me == "Z" {
			// win
			switch opponent {
			case "A":
				currentscore = win + shapeScore["B"]
			case "B":
				currentscore = win + shapeScore["C"]
			case "C":
				currentscore = win + shapeScore["A"]
			}
		}

		/*me = strings.ReplaceAll(me, "X", "A")
		me = strings.ReplaceAll(me, "Y", "B")
		me = strings.ReplaceAll(me, "Z", "C")
		fmt.Println(opponent + " " + me)

		if opponent == me {
			currentscore = draw + shapeScore[me]
			fmt.Println("draw: ", currentscore)
		} else if opponent == "A" && me == "C" {
			currentscore = lost + shapeScore[me]
			fmt.Println("opponent won", currentscore)
		} else if opponent == "B" && me == "A" {
			currentscore = lost + shapeScore[me]
			fmt.Println("opponent won", currentscore)
		} else if opponent == "C" && me == "B" {
			currentscore = lost + shapeScore[me]
			fmt.Println("opponent won", currentscore)
		} else {
			currentscore = win + shapeScore[me]
			fmt.Println("me won", currentscore)
		}*/

		score += currentscore
		fmt.Println("score", score)
	}

	readFile.Close()
}
