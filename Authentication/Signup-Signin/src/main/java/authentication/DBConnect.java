package authentication;

import java.sql.Connection;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.*;

import java.util.Random;

public class DBConnect {
    String URL = "jdbc:mysql://sqlserv:3306/skitter";
    public String createSession(String user){
        Random rand = new Random();
        String sessionID = "";
        for(int i=0; i<40;i++){
            Integer curr = new Integer(rand.nextInt(10));
            sessionID = sessionID +curr.toString();
        }
        try{
            // check if user is registered
            Class.forName("com.mysql.jdbc.Driver");
            Connection con=DriverManager.getConnection(
                    URL,"root","password");
            Statement stmt = con.createStatement();
            ResultSet res = stmt.executeQuery("select * from users where username='" + user + "'");

            if (res.isBeforeFirst()) {
                // check if the user has a session
                PreparedStatement ses = con.prepareStatement("select * from sessions where username=?");
                ses.setString(1, user);
                ResultSet rs = ses.executeQuery();
                if (!rs.isBeforeFirst()) {
                    PreparedStatement ins = con.prepareStatement("insert into sessions (username,sessionid) "
                            + "values ('" + user + "','" + sessionID +"')");
                    ins.executeUpdate();

                }
                else{
                    PreparedStatement rep = con.prepareStatement(
                            "replace into sessions VALUES ('"+ user+"','"+ sessionID + "'"
                    +")");
                    rep.executeUpdate();
                }
            }
            else return "failed";
        }
        catch (Exception e){
            e.printStackTrace();
        }
        return sessionID;
    }

    public boolean getSession(String sessionID){
        try{
            Class.forName("com.mysql.jdbc.Driver");
            Connection con=DriverManager.getConnection(
                    URL,"root","password");
            Statement stmt = con.createStatement();
            ResultSet res = stmt.executeQuery("select * from sessions where sessionid='" + sessionID + "'");
            if (res.isBeforeFirst()){
                return true;
            }

        } catch (Exception e){
            e.printStackTrace();
            return false;
        }
        return false;
    }

    public String signup(String username, String email, String name) {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection con = DriverManager.getConnection(
                    URL, "root", "password");
            Statement stmt = con.createStatement();
            ResultSet res = stmt.executeQuery("select * from users where username='" + username + "'");

            if (res.isBeforeFirst()) {
                return "Account already exists";
            }

            PreparedStatement create = con.prepareStatement(
                    "insert into users values ('" + username + "','" + email + "','"+
                            name +"')");
            create.executeUpdate();

        } catch (Exception e){
            e.printStackTrace();
            return "fail";
        }
        return "success";
    }
}
