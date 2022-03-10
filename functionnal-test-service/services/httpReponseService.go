package services

import (
	"encoding/json"
	"fmt"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type httpResponseInterface interface {
	GetByPathItem(idPathItem int) ([]*model.HttpResponse, error)
}
type httpResponseService struct {}

var HttpReponseService httpResponseInterface = &httpResponseService{}

const (
	getByPathItem = "SELECT * FROM http_response WHERE path_item_id = ?"
)

func (h httpResponseService) GetByPathItem(idPathItem int) ([]*model.HttpResponse, error) {
	stmt, err := connector.Db.Prepare(getByPathItem)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	rows, err := stmt.Query(idPathItem)
	if err != nil {
		return nil, err
	}
	defer rows.Close()
	result := make([]*model.HttpResponse, 0)
	for rows.Next() {
		var httpResponse model.HttpResponse
		if err = rows.Scan(&httpResponse.Id, &httpResponse.PathItemId, &httpResponse.HttpStatusCode, &httpResponse.Description,
			&httpResponse.Content); err != nil {
			return nil, err
		}
		if httpResponse.Content != "[]" {
			type jsonResponse struct {
				Type       string                 `json:"type"`
				Properties map[string]interface{} `json:"properties"`
			}
			jR := &jsonResponse{}
			fmt.Println(httpResponse.Content)
			err = json.Unmarshal([]byte(httpResponse.Content), &jR)
			if err != nil {
				return nil, err
			}
			toByte, err := json.Marshal(jR.Properties)
			if err != nil {
				return nil, err
			}
			httpResponse.Content = string(toByte)
		}
		result = append(result, &httpResponse)
	}
	return result, nil
}

