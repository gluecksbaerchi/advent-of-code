// advent_of_code project main.go
package main

import (
	"bufio"
	"fmt"
	"os"
	"strconv"
	"strings"
)

func main() {
	readFile, err := os.Open("day_four_input.txt")

	if err != nil {
		fmt.Println(err)
	}
	fileScanner := bufio.NewScanner(readFile)

	fileScanner.Split(bufio.ScanLines)

	total := 0
	totalPartTwo := 0
	counter := 0
	for fileScanner.Scan() {
		counter++
		fmt.Println("next pair ", counter)
		splittedLine := strings.Split(fileScanner.Text(), ",")
		elveOneSections := strings.Split(splittedLine[0], "-")
		elveTwoSections := strings.Split(splittedLine[1], "-")

		fmt.Println(elveOneSections[0], " ", elveOneSections[1])
		fmt.Println(elveTwoSections[0], " ", elveTwoSections[1])

		var err error
		x0, err := strconv.Atoi(elveOneSections[0])
		x1, err := strconv.Atoi(elveOneSections[1])
		y0, err := strconv.Atoi(elveTwoSections[0])
		y1, err := strconv.Atoi(elveTwoSections[1])

		if err != nil {
			fmt.Println("error")
		}

		if x0 <= y0 && x1 >= y1 || x0 >= y0 && x1 <= y1 {
			total++
			fmt.Println("full overlap")
		}

		if x0 <= y1 && y0 <= x1 {
			totalPartTwo++
			fmt.Println("overlap")
		}

		fmt.Println("total ", total)
		fmt.Println("total part 2", totalPartTwo)
		fmt.Println()
	}

	readFile.Close()
}
