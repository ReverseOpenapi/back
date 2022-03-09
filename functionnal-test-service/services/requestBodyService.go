package services

import (
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type RequestBodyInterface interface {
	Get(id int) (*model.RequestBody, error)
}

type requestBodyService struct {}

var RequestBodyService RequestBodyInterface = &requestBodyService{}

const (
	getRequestBody = "SELECT * FROM request_body WHERE id = ?;"
)


func (r *requestBodyService) Get(id int) (*model.RequestBody, error) {
	stmt, err := connector.Db.Prepare(getRequestBody)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	var rb model.RequestBody
	result := stmt.QueryRow(id)
	if err = result.Scan(&rb.Id, &rb.Content, &rb.Required, &rb.Description); err != nil {
		return nil, err
	}
	return &rb, nil
}
