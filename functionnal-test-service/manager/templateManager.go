package manager

import (
	"github.com/back/functionnal-test-service/integrationTemplate"
	"github.com/back/functionnal-test-service/services"
	"github.com/back/functionnal-test-service/utils"
	"github.com/back/functionnal-test-service/utils/files"
	"os"
)

type templateManagerInterface interface {
	Manager(string) error
	GetTemplateManager(item integrationTemplate.GetTemplateInterface, testNumber int) error
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
	return os.OpenFile(pwdFile, os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
}

func HeaderManager(f *os.File, randomString string) error {
	integrationTemplate.NewTemplate("localhost", f)
	err := integrationTemplate.IntegrationTemplate.Header()
	if err != nil {
		return err
	}
	err = integrationTemplate.IntegrationTemplate.SeedPost("", randomString)
	if err != nil {
		return err
	}
	return nil
}

func (t templateManager) Manager(idOpenApi string) error {
	err := files.CreateDirectory("./.export/" + idOpenApi)
	if err != nil {
		return err
	}
	tags, err  := services.TagService.GetByOpenApi(idOpenApi)
	if err != nil {
		return err
	}
	for _, tag := range tags {
		f, err := FileCreate("./.export/" + idOpenApi + "/integration_" + tag.Name + "_test.go")
		if err != nil {
			return err
		}
		randomString := utils.RandStringBytes(5)
		err = HeaderManager(f, randomString)
		if err != nil {
			return err
		}
		pathItems, err := services.PathItemService.GetByTagId(tag.Id)
		if err != nil {
			return err
		}
		for i, pathItem := range pathItems {
			switch pathItem.HttpMethod {
			case "GET":
				path, err  := services.PathService.Get(pathItem.PathId)
				if err != nil {
					return err
				}
				httpResponse, err := services.HttpReponseService.GetByPathItem(pathItem.Id)
				if err != nil {
					return err
				}
				getTemplate := integrationTemplate.NewGetTemplate("localhost", "", path.Endpoint, randomString, httpResponse , f)
				err =  t.GetTemplateManager(getTemplate, i)
				if err != nil {
					return err
				}
			}
		}
		f.Close()
	}
	return nil
}

/*
func (t templateManager) Manager(idOpenApi string) error {
	openApiService := services.OpenDocumentService
	pathService := services.PathService
	err := files.CreateDirectory("./.export/" + idOpenApi)
	if err != nil {
		return err
	}
	f, err := FileCreate("./.export/" + idOpenApi + "/integration_pet_test.go")
	defer f.Close()
	if err != nil {
		return err
	}
	integrationTemplate.NewTemplate("localhost", f)
	err = HeaderManager(f, "")
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
		for i, item := range pathItems {
			httpResponse, err := services.HttpReponseService.GetByPathItem(item.Id)
			if err != nil {
				return err
			}
			/* fmt.Printf("Method id = %v\n ", item.HttpMethodId)
			httpMethod, err := services.HttpMethodService.GetHttpMethod(item.HttpMethodId)
			if err != nil {
				return err
			}*//*
			switch item.HttpMethod {
			case "GET":
				getTemplate := integrationTemplate.NewGetTemplate("localhost", "", path.Endpoint,"", httpResponse, f)
				err = t.GetTemplateManager(getTemplate, i)
				if err != nil {
					return err
				}
			}
			fmt.Println("item", item)
		}
	}
	return nil
}*/


func (t templateManager) GetTemplateManager(pathItem integrationTemplate.GetTemplateInterface, testNumber int) error {
	err := pathItem.Get(testNumber)
	if err != nil {
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