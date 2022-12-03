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

	readFile, err := os.Open("day_three_input.txt")

	if err != nil {
		fmt.Println(err)
	}
	fileScanner := bufio.NewScanner(readFile)

	fileScanner.Split(bufio.ScanLines)

	total := 0
	for fileScanner.Scan() {
		fmt.Println("next backpack")
		line := fileScanner.Text()
		itemCount := len(line)
		firstComp := string(line[0:(itemCount / 2)])
		secondComp := string(line[(itemCount / 2):itemCount])
		fmt.Println(firstComp + " " + secondComp)

		//chFirstComp := firstComp.toCharArray();
		//chSecondComp := secondComp.toCharArray();

		result := make(map[string]string)

		for i := range firstComp {
			for j := range secondComp {
				if firstComp[i] == secondComp[j] {
					result[string(firstComp[i])] = string(firstComp[i])
				}
			}
		}

		prios := make(map[string]int)
		counter := 1
		for i := 'a'; i <= 'z'; i++ {
			prios[string(i)] = counter
			counter++
		}
		for i := 'A'; i <= 'Z'; i++ {
			prios[string(i)] = counter
			counter++
		}

		for i := range result {
			fmt.Println("equal ", result[i])
			fmt.Println("equal ", prios[result[i]])
			total += prios[result[i]]
		}
		fmt.Println("current total ", total)
	}

	fmt.Println("total ", total)

	readFile.Close()
}
