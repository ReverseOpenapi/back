package main

import (
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/manager"
	"github.com/joho/godotenv"
	"log"
	"os"
)

func checkEnv() []string {
	var errs []string
	err := godotenv.Load()
	if err != nil {
		log.Fatal("Error loading .env file")
	}

	return errs
}

func main() {
	dsn := connector.NewMysqlDb(os.Getenv("DB_USER"), os.Getenv("DB_PASSWORD"), os.Getenv("DB_NAME"), os.Getenv("DB_PORT"), os.Getenv("DB_HOSTS"))
	err := dsn.InitDb()
	if err != nil {
		panic(err)
	}

	err = connector.Db.Ping()
	if err != nil {
		panic(err)
	}

	err = manager.TemplateManager.Manager("8741762d-004a-4747-9867-863e36ad2114")
	if err != nil {
		panic(err)
	}
	/* g := model.HttpMeth
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
/*
	getTemplate := integrationTemplate.NewGetTemplate("localhost", requestBody.Content, "", r.Endpoint, 200)
	err = getTemplate.Get()
	if err != nil {
		panic(err)
	}* /
*/
}

