// advent_of_code project main.go
package main

import (
	"bufio"
	"fmt"
	"io/ioutil"
	"os"
	"strings"
)

func main() {
	filebuffer, err := ioutil.ReadFile("day_six_input.txt")
	if err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
	inputdata := string(filebuffer)
	data := bufio.NewScanner(strings.NewReader(inputdata))
	data.Split(bufio.ScanRunes)

	chars := []string{}
	count := 0
	markerLength := 14
	for data.Scan() {
		count++

		if count <= markerLength {
			chars = append(chars, data.Text())
			if count == markerLength && unique(chars) {
				fmt.Println("done", count)
				return
			}
			continue
		}

		chars = chars[1:]
		chars = append(chars, data.Text())

		for _, value := range chars {
			fmt.Print(value)
		}
		fmt.Println("")

		if unique(chars) {
			fmt.Println("done", count)
			return
		}
	}
}

func unique(stringSlice []string) bool {
	keys := make(map[string]bool)
	for _, entry := range stringSlice {
		if keys[entry] {
			return false
		}
		keys[entry] = true
	}
	return true
}
