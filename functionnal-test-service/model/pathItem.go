package model

import "database/sql"

type PathItem struct {
	Id int
	Summary string
	Description *string
	HttpMethod string
	RequestBodyId sql.NullInt64
	PathId int
}
