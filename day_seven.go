package main

import (
    "fmt"
    "strings"
    "path/filepath"
    "os"
    "bufio"
    "strconv"
    "sort"
)

func main() {
    readFile, err := os.Open("input_day_seven.txt")

    if err != nil {
        fmt.Println(err)
    }
    fileScanner := bufio.NewScanner(readFile)

    fileScanner.Split(bufio.ScanLines)

    currentPath := "/"
    allPaths := make(map[string][]int)
    allPaths["/"] = []int{}

    for fileScanner.Scan() {
        line := fileScanner.Text()

        if (line == "$ cd /" || line == "$ ls") {
            continue
        }

        if (string(line[0]) == "$") {
            whereToGo := strings.Split(line, " ")[2]
            if (whereToGo == "..") {
                currentPath = filepath.Dir(currentPath)
            } else {
                currentPath = strings.TrimSuffix(currentPath, "/") + "/" + whereToGo
            }

            _, exists := allPaths[currentPath]
            if (!exists) {
                allPaths[currentPath] = []int{}
            }
        } else {
            fileInfo := strings.Split(line, " ")
            if (fileInfo[0] == "dir") {
                continue
            }
            for key, _ := range allPaths {
                if (strings.Contains(currentPath, key)) {
                    fileSize, _ := strconv.Atoi(fileInfo[0])
                    allPaths[key] = append(allPaths[key], fileSize)
                }
            }
        }
    }

    result := 0
    sums := []int{}
    usedSpace := 0
    for key, sizes := range allPaths {
        currentResult := 0
        for _, size := range sizes {
            currentResult += size
        }
        sums = append(sums, currentResult)
        if (key == "/") {
            usedSpace = currentResult
        }
        //fmt.Println("currentResult ", currentResult)
        if (currentResult <= 100000) {
            result += currentResult
        }
    }

    fmt.Println("result 1: ", result)

    totalDiskSpace := 70000000
    requiredDiskSpace := 30000000
    needToFree := requiredDiskSpace - (totalDiskSpace - usedSpace)
    //fmt.Println(usedSpace)
    sort.Ints(sums)
    for _, value := range sums {
        if (value >= needToFree) {
            fmt.Println("result 2: ", value)
            return
        }
    }

    readFile.Close()
}