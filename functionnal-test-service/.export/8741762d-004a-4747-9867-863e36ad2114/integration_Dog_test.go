package main
	import (
	"net/http"
	"testing"
	"io"
	"log"
	"os"
	"github.com/stretchr/testify/assert"
)

func seedElementuWJRG() (interface{}, error) {
	return "", nil
	resp, err := http.Get("localhost")

    if err != nil {
      log.Fatal(err)
    }

    defer resp.Body.Close()

    _, err = io.Copy(os.Stdout, resp.Body)

    if err != nil {
      log.Fatal(err)
    }
	return "", nil
}

