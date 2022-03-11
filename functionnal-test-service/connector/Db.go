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
	Port string
	Host string
}

var Db *sql.DB

func NewMysqlDb(user, password, DbName, port, host string) *MySqlDb {
	return &MySqlDb{
		Type: "mysql",
		User: user,
		Password: password,
		DbName: DbName,
		Port: port,
		Host: host,
	}
}


func (mdb *MySqlDb) InitDb() error {
	var err error
	url := fmt.Sprintf("%v:%v@(%v:%v)/%v", mdb.User, mdb.Password, mdb.Host, mdb.Port ,mdb.DbName)
	Db, err = sql.Open(mdb.Type, url)
	return err
}