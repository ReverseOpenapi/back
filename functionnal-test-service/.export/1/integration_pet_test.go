package main
	import (
	"net/http"
	"testing"
	"io"
	"log"
	"os"
	"github.com/stretchr/testify/assert"
)

func seedElement() (interface{}, error) {
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

func TestGetOne(t *testing.T) {
	_, err := seedElement()
	if err != nil {
		t.Errorf("Error while seeding table: %s", err)
	}

	samples := struct{
		content string
		statusCode int
		errMessage string
	} {
		content: "{\"id\":1,\"description\":\"fsdfdsfdf\"}",
		statusCode: 200,
		errMessage: "",
	}

	resp, err := http.Get("http://localhost:8000/message")
	if err != nil {
		t.Errorf("Server unavailable")	
	}
	defer resp.Body.Close()
	body, err := io.ReadAll(resp.Body)
	if err != nil {
		t.Errorf("Error on reading body response")
	}
	assert.Equal(t, samples.statusCode, resp.StatusCode)
	if resp.StatusCode == samples.statusCode {
		assert.Equal(t, samples.content, string(body))
	}
}
