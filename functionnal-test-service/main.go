package main

import (
	"fmt"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/integrationTemplate"
	"github.com/back/functionnal-test-service/model"
	"github.com/back/functionnal-test-service/services"
	"github.com/back/functionnal-test-service/utils/files"
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
	a := services.PathService
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
	fmt.Println(l[0].RequestMethodId)
	requestBody, err := services.RequestBodyService.Get(l[0].RequestMethodId)
	if err != nil {
		panic(err)
	}
	fmt.Println(requestBody.Content)
	pwdPath := "./.export/1/integration_pet_test.go"
	t := integrationTemplate.NewTemplate("localhost")
	err = files.CreateFile(pwdPath)
	err = t.Header()
	if err != nil {
		panic(err)
	}
	err = t.SeedPost("")
	if err != nil {
		fmt.Println("fsddsdfs")

		panic(err)
	}
	/* err = t.GetTemplate()
	if err != nil {
		panic(err)
	}*/

	getTemplate := integrationTemplate.NewGetTemplate("localhost", requestBody.Content, "", r.Endpoint, 200)
	err = getTemplate.Get()
	if err != nil {
		panic(err)
	}
}

