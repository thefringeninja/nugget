Feature: Content Negotiation

Background:
    Given a nugget "Conneg"
        And the nugget is using component "ContentNegotiation"


Scenario: Accepts
    Given the "Accept" header is "application/json"
    When I request "/conneg/simple"
    Then the "Content-type" response header should be "application/json"
        And the response body should be json

Scenario: Multiple Accepts with quality
    Given the "Accept" header is "application/json; q=0.1, text/html; q=1.0"
    When I request "/conneg/simple"
    Then the "Content-type" response header should be "text/html"
