package manager

import "github.com/back/functionnal-test-service/services"

func TemplateManager(idPath int) error {
	pathService := services.PathService
	_, err  := pathService.Get(idPath)
	if err != nil {
		return err
	}

}