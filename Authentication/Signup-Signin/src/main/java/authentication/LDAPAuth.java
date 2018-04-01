package authentication;

import javax.naming.Context;
import java.util.Hashtable;
import javax.naming.NamingException;
import javax.naming.directory.Attributes;
import javax.naming.directory.DirContext;
import javax.naming.directory.InitialDirContext;
import javax.naming.ldap.LdapContext;


public class LDAPAuth {
    public boolean login(String username, String password) {

        Hashtable env = new Hashtable(11);
        env.put(Context.INITIAL_CONTEXT_FACTORY, "com.sun.jndi.ldap.LdapCtxFactory");
        env.put(Context.PROVIDER_URL, "ldaps://ldap.rit.edu:636");
        env.put(Context.SECURITY_AUTHENTICATION, "simple");
        env.put(Context.SECURITY_PRINCIPAL, "uid=" + username +",ou=people,dc=rit,dc=edu");
        env.put(Context.SECURITY_CREDENTIALS, password);

        try {
            DirContext ctx = new InitialDirContext(env);
            ctx.getAttributes("uid="+username+", ou=people,dc=rit,dc=edu");
            ctx.close();
            return true;
        } catch (NamingException e) {
            return false;
        }

    }

}
