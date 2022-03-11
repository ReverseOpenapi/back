package model

type SecurityScheme struct {
	Id int
	Description string
	Name string
	Scheme string
	BearerFormat string
	OpenIdConnectUrl string
}
