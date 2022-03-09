package services

import (
	"fmt"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type pathInterface interface {
	Get(id int) (*model.Path, error)
}

type pathDao struct {}

var   PathService pathInterface = &pathDao{}

const (
	getPath = "SELECT * FROM `path` WHERE id = ?;"

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
