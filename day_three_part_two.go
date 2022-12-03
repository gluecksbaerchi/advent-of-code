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
		backpackOne := fileScanner.Text()
		fileScanner.Scan()
		backpackTwo := fileScanner.Text()
		fileScanner.Scan()
		backpackThree := fileScanner.Text()

		fmt.Println(backpackOne)
		fmt.Println(backpackTwo)
		fmt.Println(backpackThree)
		fmt.Println("\n")

		badgeItems := make(map[string]string)
		for i := range backpackOne {
			for j := range backpackTwo {
				for k := range backpackThree {
					if backpackOne[i] == backpackTwo[j] && backpackTwo[j] == backpackThree[k] {
						badgeItems[string(backpackOne[i])] = string(backpackOne[i])
					}
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

		for i := range badgeItems {
			fmt.Println("equal ", badgeItems[i])
			fmt.Println("equal prio ", prios[badgeItems[i]])
			total += prios[badgeItems[i]]
		}

		fmt.Println("total ", total)

	}

	readFile.Close()
}
