package services

import (
	"fmt"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type pathInterface interface {
	Get(id int) (*model.Path, error)
	GetByOpenApiId(openApiId string) (*[]model.Path, error)
}

type pathDao struct {}

var   PathService pathInterface = &pathDao{}

const (
	getPath = "SELECT * FROM `path` WHERE id = ?;"
	getByOpenApi = "SELECT * FROM `path` WHERE open_api_document_id = ?;"
)

func (p pathDao) Get(id int) (*model.Path, error) {
	stmt, err := connector.Db.Prepare(getPath)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	var path model.Path
	result := stmt.QueryRow(id)
	if err = result.Scan(&path.Id, &path.OpenApiDocumentId, &path.Endpoint); err != nil {
		fmt.Println("this is the error man: ", err)
		return nil, err
	}
	return &path, nil
}


func (p pathDao) GetByOpenApiId(openApiId string) (*[]model.Path, error) {
	stmt, err := connector.Db.Prepare(getByOpenApi)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	rows, err := stmt.Query(openApiId)
	if err != nil {
		return nil, err
	}
	defer rows.Close()
	result := make([]model.Path, 0)
	for rows.Next() {
		var path model.Path
		if err = rows.Scan(&path.Id, &path.OpenApiDocumentId, &path.Endpoint); err != nil {
			return nil, err
		}
		result = append(result, path)
	}
	return &result, nil
}