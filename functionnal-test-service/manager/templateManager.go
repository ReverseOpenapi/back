package manager

import (
	"fmt"
	"github.com/back/functionnal-test-service/integrationTemplate"
	"github.com/back/functionnal-test-service/services"
	"github.com/back/functionnal-test-service/utils/files"
	"os"
)

type templateManagerInterface interface {
	Manager(int) error
	GetTemplateManager(item integrationTemplate.GetTemplateInterface) error
	PostTemplateManager()
	DeleteTemplateManager()
	UpdateTemplateManager()
}


type templateManager struct {}

var TemplateManager templateManagerInterface = &templateManager{}

func FileCreate(pwdFile string) (*os.File, error) {
	err := files.CreateFile(pwdFile)
	if err != nil {
		return nil, err
	}
	return os.OpenFile("./.export/1/integration_pet_test.go", os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
}

func HeaderManager() error {
	err := integrationTemplate.IntegrationTemplate.Header()
	if err != nil {
		return err
	}
	err = integrationTemplate.IntegrationTemplate.SeedPost("")
	if err != nil {
		return err
	}
	return nil
}

func (t templateManager) Manager(idOpenApi int) error {
	openApiService := services.OpenDocumentService
	pathService := services.PathService
	f, err := FileCreate("./.export/1/integration_pet_test.go")
	defer f.Close()
	if err != nil {
		return err
	}
	integrationTemplate.NewTemplate("localhost", f)
	err = HeaderManager()
	if err != nil {
		return err
	}
	openApi, err := openApiService.Get(idOpenApi)
	if err != nil {
		return err
	}
	paths, err  := pathService.GetByOpenApiId(openApi.Id)
	if err != nil {
		return err
	}
	for _, path := range *paths {
		fmt.Println(path)
		pathItems, err := services.PathItemService.GetByPAth(path.Id)
		if err != nil {
			return err
		}
		for _, item := range pathItems {
			httpResponse, err := services.HttpReponseService.GetByPathItem(item.Id)
			if err != nil {
				return err
			}
			fmt.Printf("Method id = %v\n ", item.HttpMethodId)
			httpMethod, err := services.HttpMethodService.GetHttpMethod(item.HttpMethodId)
			if err != nil {
				return err
			}
			switch httpMethod.Method {
			case "GET":
				getTemplate := integrationTemplate.NewGetTemplate("localhost", httpResponse[1].Content, "", path.Endpoint, httpResponse[1].HttpStatusCode, f)
				err = t.GetTemplateManager(getTemplate)
				if err != nil {
					return err
				}
			}
			fmt.Println("item", item)
		}
	}
	return nil
}

func (t templateManager) GetTemplateManager(pathItem integrationTemplate.GetTemplateInterface) error {
	fmt.Println(pathItem)
	err := pathItem.Get()
	if err != nil {
		fmt.Println("HAAAAAA")
		return err
	}
	return nil
	//panic("implement me")
}

func (t templateManager) PostTemplateManager() {
	panic("implement me")
}

func (t templateManager) DeleteTemplateManager() {
	panic("implement me")
}

func (t templateManager) UpdateTemplateManager() {
	panic("implement me")
}