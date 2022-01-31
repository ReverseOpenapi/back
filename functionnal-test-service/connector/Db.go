package connector

import (
	"database/sql"
	"fmt"
	_ "github.com/go-sql-driver/mysql"
)

type MySqlDb struct {
	Type string
	User string
	Password string
	DbName string
}

var Db *sql.DB

func NewMysqlDb(user string, password string, DbName string) *MySqlDb {
	return &MySqlDb{
		Type: "mysql",
		User: user,
		Password: password,
		DbName: DbName,
	}
}


func (mdb *MySqlDb) InitDb() error {
	var err error
	Db, err = sql.Open(mdb.Type, fmt.Sprintf("%v:%v@/%v", mdb.User, mdb.Password, mdb.DbName))
	return err
}