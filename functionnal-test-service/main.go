package main

import (
	"fmt"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/model"
	"github.com/back/functionnal-test-service/services"
)

func checkEnv() []string {
	var errs []string
	return errs
}

func main() {
	dsn := connector.NewMysqlDb("root", "root", "rever-openapi")
	err := dsn.InitDb()
	if err != nil {
		panic(err)
	}

	err = connector.Db.Ping()
	if err != nil {
		panic(err)
	}
	g := model.HttpMeth
	o, err := g.GetHttpMethod(3)
	if err != nil {
		fmt.Println("zfdfdsdf")
	}

	fmt.Println(o.Method)
	fmt.Println("OUIII")
	a := model.PathDao
	r, err := a.Get(1)
	if err != nil {
		panic(err)
	}
	fmt.Println(r.Endpoint)
	fmt.Println(r.OpenApiDocumentId)
	l, err := services.PathItemService.GetByPAth(r.Id)
	if err != nil {
		panic(err)
	}
	fmt.Println(l[0].Summary)
}