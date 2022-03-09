package connector

import (
	"database/sql"
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"os"
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
	url := fmt.Sprintf("%v:%v@(%v:%v)/%v", mdb.User, mdb.Password, os.Getenv("DB_HOST"), "3306" ,mdb.DbName)
	Db, err = sql.Open(mdb.Type, url)
	return err
}