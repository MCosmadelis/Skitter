package authentication;

import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class Controller {

    @RequestMapping(value = "/isAuthenticated", method = RequestMethod.POST)
    public String isAuthenticated(@RequestParam(value = "sessid") String sessId) {
        boolean dbConnect = new DBConnect().getSession(sessId);
        if (dbConnect) return "valid";
        else return "invalid";
    }

    @RequestMapping(value = "/signin", method = RequestMethod.POST)
    public String signin(@RequestParam(value = "username") String username,
                         @RequestParam(value = "password") String password) {
        boolean res = new LDAPAuth().login(username, password);
        if (res){
            return new DBConnect().createSession(username);
        }
        else return "fail";
    }

    @RequestMapping(value = "/signup", method = RequestMethod.POST)
    public String signup(@RequestParam(value = "username") String username,
                         @RequestParam(value = "email") String email,
                         @RequestParam(value = "name") String name){
        return new DBConnect().signup(username, email, name);
    }
}