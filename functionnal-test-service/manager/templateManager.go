package manager

import (
	"fmt"
	"github.com/back/functionnal-test-service/services"
)

type templateManagerInterface interface {
	Manager(int) error
	GetTemplateManager()
	PostTemplateManager()
	DeleteTemplateManager()
	UpdateTemplateManager()
}


type templateManager struct {}

var TemplateManager templateManagerInterface = &templateManager{}

func (t templateManager) Manager(idOpenApi int) error {
	openApiService := services.OpenDocumentService
	pathService := services.PathService

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
			fmt.Println("item", item)
		}
	}
	return nil
}

func (t templateManager) GetTemplateManager() {
	panic("implement me")
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