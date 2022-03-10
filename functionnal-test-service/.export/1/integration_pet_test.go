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

func TestGetOne0(t *testing.T) {
	_, err := seedElement()
	if err != nil {
		t.Errorf("Error while seeding table: %s", err)
	}
	samples := []struct{
		content string
		statusCode int
		errMessage string
	} { 
{
		content: `{"id":{"example":0},"name":{"example":"doggie"},"status":{"example":"available"}}`,
		statusCode: 200,
		errMessage: "",
	}, {
		content: `[]`,
		statusCode: 400,
		errMessage: "",
	}, {
		content: `[]`,
		statusCode: 404,
		errMessage: "",
	}, 
}

	for _, v := range samples {
		resp, err := http.Get("http://localhost:8000/pet/{id}")
		if err != nil {
			t.Errorf("Server unavailable")	
		}
		defer resp.Body.Close()
		body, err := io.ReadAll(resp.Body)
		if err != nil {
			t.Errorf("Error on reading body response")
		}
		assert.Equal(t, v.statusCode, resp.StatusCode)
		if resp.StatusCode == v.statusCode {
			assert.Equal(t, v.content, string(body))
		}
	}
}
