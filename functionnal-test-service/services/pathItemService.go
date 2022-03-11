package services

import (
	"errors"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type pathItemInterface interface {
	GetByPAth(pathId int) ([]model.PathItem, error)
	GetByTagId(int) ([]*model.PathItem, error)
}

type pathItem struct {}

var PathItemService pathItemInterface = &pathItem{}

const (
	getPathItems = "SELECT * FROM path_item WHERE path_id = ?;"
	getByTagId = "SELECT pi.id, pi.path_id, pi.request_body_id, pi.summary, pi.description, pi.http_method FROM path_item_tag LEFT JOIN path_item as pi ON pi.id = path_item_id WHERE tag_id = ?;"
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
		if err = rows.Scan(&pi.Id, &pi.PathId, &pi.RequestBodyId, &pi.Summary, &pi.Description, &pi.HttpMethod); err != nil {
			return nil, err
		}
		res = append(res, pi)
	}
	if len(res) == 0 {
		return nil, errors.New("Path item not found")
	}
	return res, nil
}

func (p *pathItem) GetByTagId(idTag int) ([]*model.PathItem, error) {
	stmt, err := connector.Db.Prepare(getByTagId)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	rows, err := stmt.Query(idTag)
	if err != nil {
		return nil, err
	}
	res := make([]*model.PathItem, 0)
	for rows.Next() {
		var pi model.PathItem
		if err = rows.Scan(&pi.Id, &pi.PathId, &pi.RequestBodyId, &pi.Summary, &pi.Description, &pi.HttpMethod); err != nil {
			return nil, err
		}
		res = append(res, &pi)
	}
	/*if len(res) == 0 {
		return nil, errors.New("Path item not found")
	}*/
	return res, nil
}

