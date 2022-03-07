package services

import (
	"errors"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type pathItemInterface interface {
	GetByPAth(pathId int) ([]model.PathItem, error)
}

type pathItem struct {}

var PathItemService pathItemInterface = &pathItem{}

const (
	getPathItems = "SELECT * FROM path_item WHERE path_id = ?;"
)

func (p *pathItem) GetByPAth(pathId int) ([]model.PathItem, error) {
	stmt, err := connector.Db.Prepare(getPathItems)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	rows, err := stmt.Query(pathId)
	if err != nil {
		return nil, err
	}
	res := make([]model.PathItem, 0)
	for rows.Next() {
		var pi model.PathItem
		if err = rows.Scan(&pi.Id, &pi.PathId, &pi.HttpMethodId, &pi.RequestMethodId, &pi.SecuritySchemeId, &pi.Summary, &pi.Description); err != nil {
			return nil, err
		}
		res = append(res, pi)
	}
	if len(res) == 0 {
		return nil, errors.New("Path item not found")
	}
	return res, nil
}
