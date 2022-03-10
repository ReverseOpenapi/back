package integrationTemplate

import (
	"os"
	"text/template"
)

type integrationTestInterface interface {
	PostTemplate() error
	GetTemplate() error
	GetAllTemplate() error
	PutTemplate() error
	DeleteTemplate() error
	SeedPost(string, string) error
	Header() error
}

var IntegrationTemplate integrationTestInterface


type integrationTemplate struct {
	url string
	f *os.File
}


func NewTemplate(url string, f *os.File) integrationTestInterface {
	IntegrationTemplate = &integrationTemplate{
		url: url,
		f: f,
	}
	return IntegrationTemplate
}


func (t *integrationTemplate) Header() error {
	temp, err := template.New("header").Parse(`package main
	import (
	"net/http"
	"testing"
	"io"
	"log"
	"os"
	"github.com/stretchr/testify/assert"
)

`)
	if err != nil {
		return err
	}
	type header struct {}
	h := header{}
	err = temp.Execute(t.f, h)
	return nil
}

func (t *integrationTemplate) SeedPost(postElement string, randomString string) error {
	temp, err  := template.New("SeedPost").Parse(`func seedElement{{.RandomString}}() (interface{}, error) {
	return "", nil
	resp, err := http.Get("{{.Url}}")

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

`)
	type ay struct {
		Url string
		RandomString string
	}
	o := ay{
		Url: "localhost",
		RandomString: randomString,
	}
	//f, err := os.OpenFile("./.export/1/integration_pet_test.go", os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
	//defer f.Close()
	if err != nil {
		return err
	}
	err = temp.Execute(t.f, o)
	if err != nil {
		return err
	}
	return nil
}

func (t *integrationTemplate) PostTemplate() error {
	panic("implement me")
}

func (t *integrationTemplate) GetTemplate() error {
	temp, err := template.New("Get").Parse(`func TestGetOne(t *testing.T) {
	_, err := seedElement()
	if err != nil {
		t.Errorf("Error while seeding table: %s", err)
	}

	samples := struct{
		content string
		statusCode int
		errMessage string
	} {
		content: {{.Content}}
		statusCode: {{.StatusCode}},
		errMessage: "",
	}

	resp, err := http.Get("http://localhost:8000/{{.PathItem}}")
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
`)
	tt := struct {
		Content string
		StatusCode int
		Err	string
		PathItem string
	} {
			Content: `"{\"id\":1,\"description\":\"fsdfdsfdf\"}",`,
			StatusCode: 200,
			Err: "",
			PathItem: "message",
	}
	f, err := os.OpenFile("./.export/1/integration_pet_test.go", os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
	defer f.Close()
	if err != nil {
		return err
	}
	err = temp.Execute(f, tt)
	if err != nil {
		return err
	}
	return nil
}

func (t *integrationTemplate) GetAllTemplate() error {
	panic("implement me")
}

func (t *integrationTemplate) PutTemplate() error {
	panic("implement me")
}

func (t *integrationTemplate) DeleteTemplate() error {
	panic("implement me")
}

/* for  _, v := range samples {
	r := gin.Default()
	r.GET("/messages/:message_id", controllers.GetMessage)
	req, err := http.NewRequest(http.MethodGet, "/messages/"+v.id, nil)
	if err != nil {
		t.Errorf("this is the error: %v\n", err)
	}
	rr := httptest.NewRecorder()
	r.ServeHTTP(rr, req)

	responseMap := make(map[string]interface{})
	err = json.Unmarshal(rr.Body.Bytes(), &responseMap)
	if err != nil {
		t.Errorf("Cannot convert to json: %v", err)
	}
	assert.Equal(t, rr.Code, v.statusCode)
	assert.Equal(t, rr.Code, v.statusCode)
	if v.statusCode == 200 {
		assert.Equal(t, responseMap["title"], v.title)
		assert.Equal(t, responseMap["body"], v.body)
	}
	if v.statusCode == 400 || v.statusCode == 422 && v.errMessage != "" {
		assert.Equal(t, responseMap["message"], v.errMessage)
	}
} */