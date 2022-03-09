package services

import (
	"fmt"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type openDocumentService struct {}

type openDocumentInterface interface {
	Get(int) (*model.OpenApiDocument, error)
}

const (
	getOpenDocument = "SELECT * FROM open_api_document WHERE id = ?"
)

var OpenDocumentService openDocumentInterface = &openDocumentService{}

func (o openDocumentService) Get(idOpenApi int) (*model.OpenApiDocument, error) {
	stmt, err := connector.Db.Prepare(getOpenDocument)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	var openApi *model.OpenApiDocument
	result := stmt.QueryRow(idOpenApi)
	if err = result.Scan(&openApi.Id, &openApi.Title, &openApi.Description); err != nil {
		fmt.Println("this is the error man: ", err)
		return nil, err
	}
	return openApi, nil
}
