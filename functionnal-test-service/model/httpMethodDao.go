package model

import (
	"errors"
	"fmt"
	"github.com/back/functionnal-test-service/connector"
)

type httpMethodInterface interface {
	GetHttpMethod(id int) (*HttpMethod, error)
}

type httpMethodDao struct {}


var HttpMeth  httpMethodInterface = &httpMethodDao{}

const (
	getHttpMethodDao = "SELECT * FROM http_method WHERE id = ?;"
	getHttpMethodsDao = "SELECT * FROM http_method;"

)

func (h *httpMethodDao) GetHttpMethod(id int) (*HttpMethod, error) {
	stmt, err := connector.Db.Prepare(getHttpMethodDao)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	var hm HttpMethod
	result := stmt.QueryRow(id)
	if err = result.Scan(&hm.Id, &hm.Method); err != nil {
		fmt.Println("this is the error man: ", err)
		return nil, err
	}
	return &hm, nil
}


func (h *httpMethodDao) GetHttpMethods(id int) (*[]HttpMethod, error) {
	stmt, err := connector.Db.Prepare(getHttpMethodsDao)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	rows, err := stmt.Query()
	if err != nil {
		return nil, err
	}
	defer rows.Close()
	res := make([]HttpMethod, 0)
	for rows.Next() {
		var hm HttpMethod
		if err = rows.Scan(&hm.Id, &hm.Method); err != nil {
			return nil, err
		}
		res = append(res, hm)
	}
	if len(res) == 0 {
		return nil, errors.New("httpMethod not found")
	}
	return &res, nil
}

