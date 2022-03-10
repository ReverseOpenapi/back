package model

import "database/sql"

type PathItem struct {
	Id int
	Summary string
	Description *string
	HttpMethodId int
	RequestMethodId int
	RequestBodyId sql.NullInt64
	SecuritySchemeId *int
	PathId int
}
