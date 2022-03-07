package model

import (
	"fmt"
	"github.com/back/functionnal-test-service/connector"
)

type pathInterface interface {
	Get(id int) (*Path, error)
}

type pathDao struct {}

var   PathDao pathInterface = &pathDao{}

const (
	getPath = "SELECT * FROM `path` WHERE id = ?;"

)


func (p pathDao) Get(id int) (*Path, error) {
	stmt, err := connector.Db.Prepare(getPath)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	var path Path
	result := stmt.QueryRow(id)
	if err = result.Scan(&path.Id, &path.OpenApiDocumentId, &path.Endpoint); err != nil {
		fmt.Println("this is the error man: ", err)
		return nil, err
	}
	return &path, nil
}
