package integrationTemplate

import (
	"fmt"
	"os"
	"path"
	"text/template"
)

type getTemplate struct {
	url string
	httpResponse string
	statusCode int
	err string
	pathItem string
}

type getTemplateInterface interface {
	SeedMessage()
	Get() error
}

var (
	GetTemplate getTemplateInterface
)


func NewGetTemplate(url, httpResponse, err, pathItem string, statusCode int) getTemplateInterface {
	GetTemplate = &getTemplate{
		url: url,
		httpResponse: httpResponse,
		statusCode: statusCode,
		err: err,
		pathItem: pathItem,
	}
	return GetTemplate;
}

func (g *getTemplate) SeedMessage() {
	fmt.Println("fdsf")
}

func (g *getTemplate) Get() error {
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
		content: {{.Content}},
		statusCode: {{.StatusCode}},
		errMessage: "{{.Err}}",
	}

	resp, err := http.Get("http://{{.Url}}:8000{{.PathItem}}")
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
		Url string
		PathItem string
	} {
		Content: fmt.Sprintf("`%v`", path.Clean(g.httpResponse)), //`"{\"id\":1,\"description\":\"fsdfdsfdf\"}",`,
		StatusCode: g.statusCode,
		Url: g.url,
		Err: g.err,
		PathItem: g.pathItem,
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