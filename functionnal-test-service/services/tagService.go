package services

import (
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
)

type tagService struct {}

type tagInterface interface {
	GetByOpenApi(string) ([]*model.Tag, error)
}

const (
	getTag = "SELECT * FROM tag WHERE open_api_document_id = ?"
)

var TagService tagInterface = &tagService{}

func (o *tagService) GetByOpenApi(idOpenApi string) ([]*model.Tag, error) {
	stmt, err := connector.Db.Prepare(getTag)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	rows, err := stmt.Query(idOpenApi)
	defer rows.Close()
	res := make([]*model.Tag, 0)
	for rows.Next() {
		var tag model.Tag
		if err = rows.Scan(&tag.Id, &tag.OpenApiDocumentId, &tag.Name, &tag.Description); err != nil {
			return nil, err
		}
		res = append(res, &tag)
	}
	return res, nil
}
