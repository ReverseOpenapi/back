package services

import (
	"errors"
	"fmt"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type httpMethodInterface interface {
	GetHttpMethod(id int) (*model.HttpMethod, error)
}

type httpMethodService struct {}


var HttpMethodService httpMethodInterface = &httpMethodService{}

const (
	getHttpMethodDao = "SELECT * FROM http_method WHERE id = ?;"
	getHttpMethodsDao = "SELECT * FROM http_method;"

)

func (h *httpMethodService) GetHttpMethod(id int) (*model.HttpMethod, error) {
	stmt, err := connector.Db.Prepare(getHttpMethodDao)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	var hm model.HttpMethod
	result := stmt.QueryRow(id)
	if err = result.Scan(&hm.Id, &hm.Method); err != nil {
		fmt.Println("this is the error man: ", err)
		return nil, err
	}
	return &hm, nil
}


func (h *httpMethodService) GetHttpMethods(id int) (*[]model.HttpMethod, error) {
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
	res := make([]model.HttpMethod, 0)
	for rows.Next() {
		var hm model.HttpMethod
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
