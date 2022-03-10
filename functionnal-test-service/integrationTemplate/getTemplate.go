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
	f *os.File
}

type GetTemplateInterface interface {
	SeedMessage()
	Get() error
}

var (
	GetTemplate GetTemplateInterface
)


func NewGetTemplate(url, httpResponse, err, pathItem string, statusCode int, f *os.File) GetTemplateInterface {
	GetTemplate = &getTemplate{
		url: url,
		httpResponse: httpResponse,
		statusCode: statusCode,
		err: err,
		pathItem: pathItem,
		f: f,
	}
	return GetTemplate
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
	fmt.Printf("`%v`\n", path.Clean(g.httpResponse))
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
	fmt.Println(g.f)
	err = temp.Execute(g.f, tt)
	if err != nil {
		return err
	}
	return nil
}