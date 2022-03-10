package integrationTemplate

import (
	"bytes"
	"fmt"
	"github.com/back/functionnal-test-service/model"
	"os"
	"path"
	"text/template"
)

type getTemplate struct {
	url string
	httpResponse []*model.HttpResponse
//	httpResponse []string
//	statusCode []int
	err string
	pathItem string
	f *os.File
	randomStringSeed string
}

type GetTemplateInterface interface {
	SeedMessage()
	Get(int) error
}

var (
	GetTemplate GetTemplateInterface
)


func NewGetTemplate(url, err, pathItem, randomStringSeed string, httpResponse []*model.HttpResponse, f *os.File) GetTemplateInterface {
	GetTemplate = &getTemplate{
		url: url,
		httpResponse: httpResponse,
		//statusCode: statusCode,
		err: err,
		pathItem: pathItem,
		f: f,
		randomStringSeed: randomStringSeed,
	}
	return GetTemplate
}

func (g *getTemplate) SeedMessage() {
	fmt.Println("fdsf")
}

func createSample(httpResponses []*model.HttpResponse) (string, error) {
	var tpl bytes.Buffer
	t, err  := template.New("Sample").Parse(`samples := []struct{
		content string
		statusCode int
		errMessage string
	} { 
`)
	if 	err != nil {
		return "", err
	}
	if err := t.Execute(&tpl, ""); err != nil {
		return "", err
	}
	for _, response := range httpResponses {
		s, err := template.New("data").Parse(`{
		content: {{.Content}},
		statusCode: {{.StatusCode}},
		errMessage: "",
	}, `)
		sampleStruct := struct {
			Content string
			StatusCode int
		}{
			fmt.Sprintf("`%v`", path.Clean(response.Content)),
			response.HttpStatusCode,
		}
		if err != nil {
			return "", err
		}
		if err := s.Execute(&tpl, sampleStruct); err != nil{
			return "", err
		}
	}
	end, err := template.New("end").Parse(`
}`)
	if err != nil {
		return "", err
	}
	if err = end.Execute(&tpl, ""); err != nil {
		return "", nil
	}
	return tpl.String(), nil
}


func (g *getTemplate) Get(testNumber int) error {
	temp, err := template.New("Get").Parse(`func TestGet{{.TestNumber}}(t *testing.T) {
	_, err := seedElement{{.RandomStringSeed}}()
	if err != nil {
		t.Errorf("Error while seeding table: %s", err)
	}
	{{.Sample}}

	for _, v := range samples {
		resp, err := http.Get("http://{{.Url}}:8000{{.PathItem}}")
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
`)
	//fmt.Printf("`%v`\n", path.Clean(g.httpResponse))
	samples, err := createSample(g.httpResponse)
	if err != nil {
		return err
	}
	 tt := struct {
		 TestNumber int
		 Sample string
		 Err	string
		 Url string
		 PathItem string
		 RandomStringSeed string
	} {
		 TestNumber: testNumber,
		Sample: samples,
		Url: g.url,
		Err: g.err,
		PathItem: g.pathItem,
		RandomStringSeed: g.randomStringSeed,
	}
	err = temp.Execute(g.f, tt)
	if err != nil {
		return err
	}
	return nil
}
