/*package main

import (
	"bufio"
	"errors"
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
	// reading from stdin line by line
	scanner := bufio.NewScanner(readFile)
	var part1, part2 int // will hold the answers for both parts
	for scanner.Scan() {
		// extract the bounds of each elf's section
		// if there's any errors in input, print out the error and move on to the next line
		line := scanner.Text() // read the line
		sections := strings.Split(line, ",")
		if len(sections) != 2 {
			fmt.Fprintln(os.Stderr, "'"+line+"' is not formatted properly!")
			continue
		}
		leftBounds, err := getBounds(sections[0])
		if err != nil {
			fmt.Fprintln(os.Stderr, err.Error())
			continue
		}
		rightBounds, err := getBounds(sections[1])
		if err != nil {
			fmt.Fprintln(os.Stderr, err.Error())
			continue
		}

		// bounds will always be a int array of size 2
		// index 0 -> lower bound of range
		// index 1 -> upper bound of range

		// Part 1 asks to check if one range completely engulfs the other
		// this is determined by finding if one side's upper bound <= the other's and lower bound >= the other's (i.e. if both bounds of one side are within the range of the other's bounds)
		if (leftBounds[0] <= rightBounds[0] && leftBounds[1] >= rightBounds[1]) || (rightBounds[0] <= leftBounds[0] && rightBounds[1] >= leftBounds[1]) {
			part1++
		}

		// Part 2 asks to check for any overlaps
		// overlaps are defined by lower bounds being in the range of the other's bounds
		if (rightBounds[0] <= leftBounds[1] && rightBounds[0] >= leftBounds[0]) || (leftBounds[0] <= rightBounds[1] && leftBounds[0] >= rightBounds[0]) {
			part2++
		}
	}
	// print the final answers
	fmt.Println(part1, part2)
}

// takes a string like "<n>-<m>" and will return a array of size 2 containing n and m as ints
func getBounds(section string) ([2]int, error) {
	var bounds [2]int // will hold the bounds
	// get n and m by spliting the section string by the '-'
	boundsAsStrings := strings.Split(section, "-")
	if len(boundsAsStrings) != 2 {
		return bounds, errors.New("'" + section + "' is not formatted properly")
	}
	var err error // will hold any error in conversion
	// convert n (i.e. the lower bound) to an int
	bounds[0], err = strconv.Atoi(boundsAsStrings[0])
	if err != nil {
		return bounds, err
	}
	// convert m (i.e. the upper bound) to an int
	bounds[1], err = strconv.Atoi(boundsAsStrings[1])
	if err != nil {
		return bounds, err
	}
	return bounds, nil
}
*/
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
