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
	readFile, err := os.Open("day_five_input.txt")

	if err != nil {
		fmt.Println(err)
	}
	fileScanner := bufio.NewScanner(readFile)

	fileScanner.Split(bufio.ScanLines)

	crateStacks := map[int][]string{
		1: []string{"B", "W", "N"},
		2: []string{"L", "Z", "S", "P", "T", "D", "M", "B"},
		3: []string{"Q", "H", "Z", "W", "R"},
		4: []string{"W", "D", "V", "J", "Z", "R"},
		5: []string{"S", "H", "M", "B"},
		6: []string{"L", "G", "N", "J", "H", "V", "P", "B"},
		7: []string{"J", "Q", "Z", "F", "H", "D", "L", "S"},
		8: []string{"W", "S", "F", "J", "G", "Q", "B"},
		9: []string{"Z", "W", "M", "S", "C", "D", "J"},
	}

	//	total := ""
	for fileScanner.Scan() {
		splittedLine := strings.Split(fileScanner.Text(), " ")
		count, _ := strconv.Atoi(splittedLine[1])
		from, _ := strconv.Atoi(splittedLine[3])
		to, _ := strconv.Atoi(splittedLine[5])

		/*for i := 1; i <= count; i++ {
			crateStacks[to] = append(crateStacks[to], crateStacks[from][len(crateStacks[from])-1])
			crateStacks[from] = crateStacks[from][:len(crateStacks[from])-1]
		}*/

		crateStacks[to] = append(crateStacks[to], crateStacks[from][len(crateStacks[from])-count:len(crateStacks[from])]...)
		crateStacks[from] = crateStacks[from][:len(crateStacks[from])-count]

		for i := 1; i <= 9; i++ {
			fmt.Println(crateStacks[i])
		}

		fmt.Println()
	}

	readFile.Close()
}
