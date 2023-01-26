<?php 

    if(isset($_POST["position"]) && isset($_POST["department"])){

        require "../includes/connection.php";

        $position   = $_POST["position"];
        $department = $_POST["department"];
        $response = array();

        $sql = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:department");
        $sql->execute([ "department" => $department ]);
        $row = $sql->fetch();
        $headOffice = empty($row["headOffice"]) ? $department : $row["headOffice"];
        $response["headOffice"] = $headOffice;
        $branchCode = $row["code"];

        if($row["type"] == "branch"){
            $error = 0;

            $sql = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
            $sql->execute([ "id" => $position ]);
            $row = $sql->fetch();
            $rank = $row["type"];
            if($rank < 3){
                $supervisor = 2;
                $response["supervisor"] = array();
                $response["valueSup"] = array();
                $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank>:rank");
                $sql->execute([
                    "department"    => $department,
                    "rank"          => $supervisor
                ]);
                while($row = $sql->fetch()){
                    $middleName = empty($row["middleName"]) ? "" : ucwords($row["middleName"][0]);
                    $fullName = ucwords($row["lastName"]) . ", " . ucwords($row["firstName"]) . " " . $middleName . ".";

                    $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                    $sqlP->execute([ "id" => $row["position"] ]);
                    $rowP = $sqlP->fetch();
                    array_push($response["supervisor"],$fullName . " (". $rowP["position"] .")");
                    array_push($response["valueSup"],$row["id"]);
                }

                $response["rank"] = $rank;
                $response["result"] = true;
            }else{
                $response["supervisor"] = array();
                $response["valueSup"] = array();
                $sql = $conn->prepare("SELECT * FROM dbo.districts");
                $sql->execute();
                while($rowD = $sql->fetch()){
                    $branches = unserialize($rowD["branches"]);
                    if(in_array($branchCode,$branches)){
                        $managerID = $rowD["manager"];
                        $rowD = false; 
                    }
                }

                $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                $sql->execute([
                    "employeeID" => $managerID
                ]);
                $row = $sql->fetch();
                if($row){
                    $middleName = empty($row["middleName"]) ? "" : ucwords($row["middleName"][0]);
                    $fullName = ucwords($row["lastName"]) . ", " . ucwords($row["firstName"]) . " " . $middleName . ".";

                    $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                    $sqlP->execute([ "id" => $row["position"] ]);
                    $rowP = $sqlP->fetch();
                    array_push($response["supervisor"],$fullName . " (". $rowP["position"] .")");
                    array_push($response["valueSup"],$row["id"]);

                    $response["rank"] = $rank;
                    $response["result"] = true;
                }
                
            }

            $rank = 4;
            $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank=:rank");
            $sql->execute([
                "department"    => $headOffice,
                "rank"          => $rank
            ]);
            $row = $sql->fetch();
            $middleName = empty($row["middleName"]) ? "" : ucwords($row["middleName"][0]);
            $fullName = ucwords($row["lastName"]) . ", " . ucwords($row["firstName"]) . " " . $middleName . ".";
            
            $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
            $sqlP->execute([ "id" => $row["position"] ]);
            $rowP = $sqlP->fetch();
            $response["chief"] = $fullName . " (". $rowP["position"] .")";;
            $response["valueChief"] = $row["id"];

        }else{
            $sql = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
            $sql->execute([ "id" => $position ]);
            $row = $sql->fetch();
            $rank = $row["type"];
            if($row["position"] != "District Manager"){
                if($rank == 4){
                    $response["supervisor"]     = "Board Of Directors";
                    $response["chief"]          = "Board Of Directors";
                    $response["valueSup"]       = "BOD";
                    $response["valueChief"]     = "BOD";
                    $response["rank"]     = $rank;
                    $response["result"]         = true;
                }else if($rank == 3){
                    $chief = 4;
                    $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank=:rank");
                    $sqlE->execute([
                        "department" => $headOffice,
                        "rank"       => $chief
                    ]);
                    $rowE = $sqlE->fetch();
                    if($rowE){
                        
                        $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                        $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";
                        $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                        $sqlP->execute([ "id" => $rowE["position"] ]);
                        $rowP = $sqlP->fetch();
                        $response["supervisor"] = $fullName . " (". $rowP["position"] .")";
                        $response["chief"]      = $fullName . " (". $rowP["position"] .")";
                        $response["rank"] = $rank;
                        $response["valueSup"]   = $rowE["id"];
                        $response["valueChief"] = $rowE["id"];
                        $response["result"]     = true;

                    }else{
                        $response["result"] = false;
                    }
                    
                    
                }else if($rank == 2){
                    $supervisor = 3;
                    $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank >= :rank");
                    $sqlE->execute([
                        "department" => $department,
                        "rank"       => $supervisor
                    ]);
                    $rowE = $sqlE->fetch();
                    if($rowE){
                        
                        $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                        $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";
                        $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                        $sqlP->execute([ "id" => $rowE["position"] ]);
                        $rowP = $sqlP->fetch();
                        $response["supervisor"] = $fullName . " (". $rowP["position"] .")";
                        $response["headOffice"] = $rank;
                        $response["valueSup"]   = $rowE["id"];

                        $chief = 4;
                        $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank=:rank");
                        $sqlE->execute([
                            "department" => $headOffice,
                            "rank"       => $chief
                        ]);
                        $rowE = $sqlE->fetch();
                        if($rowE){
                        
                            $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                            $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";
                            $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                            $sqlP->execute([ "id" => $rowE["position"] ]);
                            $rowP = $sqlP->fetch();
                            $response["chief"]      = $fullName . " (". $rowP["position"] .")";
                            $response["valueChief"] = $rowE["id"];
                            $response["rank"]       = $rank;
                            $response["result"]     = true;
        
                        }
                    }else{
                        $response["result"] = false;
                    }
                }else{
                    $supervisor = 2;
                    $chief = 4;
                    $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank >= :rank");
                    $sqlE->execute([
                        "department" => $department,
                        "rank"       => $supervisor,
                    ]);
                    $response["supervisor"] = array();
                    $response["valueSup"] = array();
                    while($rowE = $sqlE->fetch()){

                        $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                        $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";
                        $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                        $sqlP->execute([ "id" => $rowE["position"] ]);
                        $rowP = $sqlP->fetch();
                        array_push($response["supervisor"],$fullName . " (". $rowP["position"] .")");
                        array_push($response["valueSup"],$rowE["id"]);

                    }

                    if(count($response["supervisor"]) > 0){

                        $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank=:rank");
                        $sqlE->execute([
                            "department" => $headOffice,
                            "rank"       => $chief
                        ]);
                        $rowE = $sqlE->fetch();
                        if($rowE){
                        
                            $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                            $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";
                            $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                            $sqlP->execute([ "id" => $rowE["position"] ]);
                            $rowP = $sqlP->fetch();
                            $response["chief"]      = $fullName . " (". $rowP["position"] .")";
                            $response["rank"] = $rank;
                            $response["valueChief"] = $rowE["id"];
                            $response["result"]     = true;
        
                        }

                    }else{
                        $response["result"] = false;
                    }
                    
                }
            }else{
                $chief = 4;
                $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank=:rank");
                $sqlE->execute([
                    "department" => $department,
                    "rank"       => $chief
                ]);
                $rowE = $sqlE->fetch();
                if($rowE){
                    
                    $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                    $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";
                    $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                    $sqlP->execute([ "id" => $rowE["position"] ]);
                    $rowP = $sqlP->fetch();
                    $response["supervisor"] = $fullName . " (". $rowP["position"] .")";
                    $response["chief"]      = $fullName . " (". $rowP["position"] .")";
                    $response["rank"] = $rank;
                    $response["valueSup"]   = $rowE["id"];
                    $response["valueChief"] = $rowE["id"];
                    $response["result"]     = true;

                }else{
                    $response["result"] = false;
                }
            }
        }

        echo json_encode($response);
    }

?>